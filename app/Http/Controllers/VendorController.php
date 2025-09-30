<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Enums\VendorStatusEnum;
use App\Http\Resources\ProductListResource;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Models\VendorPendingChange;

class VendorController extends Controller
{
    public function profile(Request $request, Vendor $vendor)
    {
        $coverMedia = $vendor->getFirstMedia('cover_images');
        $keyword = $request->query('keyword');
        $products = Product::query()
            ->forWebsite()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%{$keyword}%")
                        ->orWhere('description', 'LIKE', "%{$keyword}%");
                });
            })
            ->where('created_by', $vendor->user_id)
            ->paginate(24);

        return Inertia::render('Vendor/Profile', [
            'vendor' => $vendor,
            'coverImage' => $coverMedia ? $coverMedia->getUrl() : null,
            'products' => ProductListResource::collection($products),
        ]);
    }


    public function store(Request $request)
    {
        $user = $request->user();
        $isNewVendor = !$user->vendor;
        $vendor = $user->vendor ?: new Vendor();

        // --- التحقق من وجود ملفات قديمة ---
        $existingIdCard = $vendor->getFirstMedia('id_card') ? true : false;
        $existingTrade = $vendor->getFirstMedia('trade_license') ? true : false;

        // --- قواعد التحقق ---
        $idCardRule = ($isNewVendor && !$existingIdCard)
            ? 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
            : 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';

        $tradeLicenseRule = ($isNewVendor && !$existingTrade)
            ? 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
            : 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';

        // --- تطبيع اسم المتجر ---
        $normalizedStoreName = null;
        if ($request->filled('store_name')) {
            $slug = preg_replace('/\s+/u', '-', trim($request->input('store_name')));
            $slug = mb_strtolower($slug);
            $slug = preg_replace('/[^\p{Arabic}a-z0-9-]+/iu', '', $slug);
            $normalizedStoreName = $slug;
        }

        $rules = [
            'store_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{Arabic}a-z0-9-]+$/u',
                Rule::unique('vendors', 'store_name')->ignore($user->id, 'user_id')
            ],
            'store_address' => 'nullable|string|max:1000',
            'id_card' => $idCardRule,
            'trade_license' => $tradeLicenseRule,
            'cover_image' => 'nullable|image|max:4096',
        ];

        $messages = [
            'store_name.regex' => 'يجب أن يحتوي اسم المتجر على أحرف عربية أو إنجليزية وأرقام وشرطات فقط.',
            'id_card.required' => 'رفع صورة الهوية مطلوب.',
            'trade_license.required' => 'رفع الرخصة التجارية مطلوب.',
            'cover_image.image' => 'صورة الغلاف يجب أن تكون ملف صورة صالح.',
        ];

        $validator = Validator::make(array_merge($request->all(), [
            'store_name' => $normalizedStoreName ?? $request->input('store_name')
        ]), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            if ($isNewVendor) {
                $vendor->user_id = $user->id;

                // حفظ إحداثيات افتراضية
                $defaultAddress = $user->shippingAddress()->where('default', 1)->first();
                if ($defaultAddress) {
                    $vendor->latitude = $defaultAddress->latitude;
                    $vendor->longitude = $defaultAddress->longitude;
                }

                $vendor->status = VendorStatusEnum::Pending->value;
            }

            // تحديث الحقول المباشرة
            $vendor->store_address = $request->input('store_address');
            $vendor->save();

            // --- دالة مساعدة لحفظ الملفات مؤقتًا ---
            $saveTempFile = function ($file, $folder) use ($user) {
                $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());
                $path = "vendor_pending/{$user->id}/{$folder}/{$filename}";
                Storage::disk('local')->putFileAs("vendor_pending/{$user->id}/{$folder}", $file, $filename);
                return $path;
            };

            // --- إنشاء تغييرات معلقة ---
            $createPendingChange = function ($field, $oldValue, $newValue) use ($vendor) {
                VendorPendingChange::create([
                    'vendor_id' => $vendor->user_id,
                    'field' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'status' => 'pending',
                ]);
            };

            // 1️⃣ اسم المتجر
            if ($normalizedStoreName && $normalizedStoreName !== $vendor->store_name) {
                $createPendingChange('store_name', $vendor->store_name, $normalizedStoreName);
            }

            foreach (
                [
                    'cover_image' => 'cover_images',
                    'id_card' => 'id_card',
                    'trade_license' => 'trade_license'
                ] as $fileField => $collectionName
            ) {
                if ($request->hasFile($fileField)) {
                    $path = $saveTempFile($request->file($fileField), $fileField);

                    // تخزين القيمة القديمة من الـ collection الصحيح
                    $oldValue = $vendor->getFirstMedia($collectionName)?->getPath() ?? null;

                    $createPendingChange($fileField, $oldValue, $path);
                }
            }


            // --- إضافة دور بائع إن لم يكن موجود ---
            if (!$user->hasRole(RolesEnum::Vendor)) {
                $user->assignRole(RolesEnum::Vendor);
            }

            DB::commit();
            return back()->with('successToast', 'تم إرسال التغييرات للمراجعة. سيقوم الفريق بمراجعتها قريباً.');
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Vendor store/update failed for user_id=' . $user->id . ' : ' . $ex->getMessage(), [
                'trace' => $ex->getTraceAsString()
            ]);
            return back()->with('errorToast', 'حدث خطأ أثناء معالجة طلبك. الرجاء المحاولة لاحقاً أو التواصل مع الدعم.');
        }
    }




    public function deleteCoverImage(Request $request)
    {
        $user = $request->user();

        if (!$user->vendor) {
            return redirect()->route('profile.edit')
                ->with('errorToast', 'لا يوجد متجر مرتبط بالمستخدم');
        }

        $vendor = $user->vendor;

        $media = $vendor->getFirstMedia('cover_images');
        if ($media) {
            $media->delete(); // حذف الصورة من MediaLibrary
        } else {
            return redirect()->route('profile.edit')
                ->with('errorToast', 'لا توجد صورة غلاف لحذفها.');
        }

        return redirect()->route('profile.edit')
            ->with('successToast', 'تم حذف صورة الغلاف بنجاح.');
    }
}
