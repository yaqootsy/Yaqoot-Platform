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
        // dd($request->hasFile('cover_image'));
        $user = $request->user();
        // Now this works
        $request->validate([
            'store_name' => [
                'required',
                'regex:/^[\p{Arabic}a-z0-9-]+$/u', // يسمح بالعربية والانجليزية والأرقام والشرطات
                Rule::unique('vendors', 'store_name')
                    ->ignore($user->id, 'user_id')
            ],
            'store_address' => 'nullable',
        ], [
            'store_name.regex' => 'يجب أن يحتوي اسم المتجر على أحرف عربية أو إنجليزية وأرقام وشرطات فقط.',
        ]);

        $vendor = $user->vendor ?: new Vendor();
        $vendor->user_id = $user->id;

        // حفظ الاسم القديم قبل التعديل
        $oldStoreName = $vendor->store_name;

        $vendor->status = VendorStatusEnum::Approved->value;
        $vendor->store_name = $request->store_name;
        $vendor->store_address = $request->store_address;
        $vendor->save();

        if ($request->hasFile('cover_image')) {
            $vendor->addMediaFromRequest('cover_image')
                ->toMediaCollection('cover_images');
        }

        $user->assignRole(RolesEnum::Vendor);

        // ✅ فقط إذا تغيّر الاسم
        if ($oldStoreName !== $vendor->store_name) {
            Product::where('created_by', $user->id)
                ->lazyById(500)
                ->each(function ($product) {
                    dispatch(function () use ($product) {
                        $product->searchable();
                    });
                });
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
