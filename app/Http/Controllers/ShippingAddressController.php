<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingAddressRequest;
use App\Http\Resources\ShippingAddressResource;
use App\Models\Address;
use App\Models\Country;
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
        $user = Auth::user();
        $address = $user->shippingAddresses()->create($request->validated());
        if ($request->primary) {
            $user->shippingAddresses()
                ->where('id', '!=', $address->id)
                ->update(['primary' => false]);
        }
        return redirect()->route('shippingAddress.index')
            ->with('success', 'Shipping address created.');
    }

    public function update(ShippingAddressRequest $request, Address $address)
    {
        $user = Auth::user();
        $address->update($request->validated());
        if ($request->primary) {
            $user->shippingAddresses()
                ->where('id', '!=', $address->id)
                ->update(['primary' => false]);
        }
        return redirect()->route('shippingAddress.index')
            ->with('success', 'Shipping address updated.');
    }

    public function makeDefault(Address $address)
    {
        $user = Auth::user();
        $user->shippingAddresses()
            ->where('id', '!=', $address->id)
            ->update(['primary' => false]);

        $address->update(['primary' => 1]);
        return redirect()->route('shippingAddress.index')
            ->with('successToast', 'Default shipping address updated.');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('shippingAddress.index')
            ->with('successToast', 'Shipping address deleted.');
    }
}
