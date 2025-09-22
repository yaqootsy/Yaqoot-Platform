<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingAddressRequest;
use App\Http\Resources\ShippingAddressResource;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $countries = Country::where('active', true)->orderBy('name')->get();
        $addresses = $user->shippingAddresses()->latest()->with('country')->get();
        return Inertia::render('ShippingAddress/Index', [
            'addresses' => ShippingAddressResource::collection($addresses)->collection->toArray(),
            'countries' => $countries,
        ]);
    }

    public function store(ShippingAddressRequest $request)
    {
        Log::debug($request->all());
        $user = Auth::user();
        $address = $user->shippingAddresses()->create($request->validated());
        if ($request->default) {
            $user->shippingAddresses()
                ->where('id', '!=', $address->id)
                ->update(['default' => false]);
        }
        return redirect()->route('shippingAddress.index')
            ->with('successToast', 'تم إنشاء عنوان الشحن.');
    }

    public function update(ShippingAddressRequest $request, Address $address)
    {
        Log::debug($request->validated());

        // dd($request);
        if (!$address->belongs(auth()->user())) {
            abort(403, "Unauthorized");
        }
        $user = Auth::user();
        $address->update($request->validated());
        if ($request->default) {
            $user->shippingAddresses()
                ->where('id', '!=', $address->id)
                ->update(['default' => false]);
        }
        return redirect()->route('shippingAddress.index')
            ->with('successToast', 'تم تحديث عنوان الشحن.');
    }

    public function makeDefault(Address $address)
    {
        if (!$address->belongs(auth()->user())) {
            abort(403, "Unauthorized");
        }
        $user = Auth::user();
        $user->shippingAddresses()
            ->where('id', '!=', $address->id)
            ->update(['default' => false]);

        $address->update(['default' => 1]);
        return redirect()->route('shippingAddress.index')
            ->with('successToast', 'تم تحديث عنوان الشحن الافتراضي.');
    }

    public function destroy(Address $address)
    {
        if (!$address->belongs(auth()->user())) {
            abort(403, "Unauthorized");
        }
        $address->delete();
        return redirect()->route('shippingAddress.index')
            ->with('successToast', 'تم حذف عنوان الشحن.');
    }
}
