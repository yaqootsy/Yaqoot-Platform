<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;

// Guest Routes
Route::get('/', [ProductController::class, 'home'])->name('dashboard');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/d/{department:slug}', [ProductController::class, 'byDepartment'])
    ->name('product.byDepartment');

Route::get('/s/{vendor:store_name}', [VendorController::class, 'profile'])
    ->name('vendor.profile');

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add/{product}', 'store')
        ->name('cart.store');
    Route::put('/cart/{product}', 'update')
        ->name('cart.update');
    Route::delete('/cart/{product}', 'destroy')
        ->name('cart.destroy');
    Route::put('/cart/update-shipping-address/{address}', [CartController::class, 'updateShippingAddress'])
        ->name('cart.shippingAddress');
});

Route::post('/stripe/webhook', [StripeController::class, 'webhook'])
    ->name('stripe.webhook');

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/shipping-address', [ShippingAddressController::class, 'index'])
        ->name('shippingAddress.index');

    Route::post('/shipping-address', [ShippingAddressController::class, 'store'])
        ->name('shippingAddress.store');

    Route::put('/shipping-address/{address}', [ShippingAddressController::class, 'update'])
        ->name('shippingAddress.update');

    Route::put('/shipping-address/make-default/{address}', [ShippingAddressController::class, 'makeDefault'])
        ->name('shippingAddress.makeDefault');

    Route::delete('/shipping-address/{address}', [ShippingAddressController::class, 'destroy'])
        ->name('shippingAddress.destroy');

    Route::middleware(['verified'])->group(function () {
        Route::post('/cart/checkout', [CartController::class, 'checkout'])
            ->name('cart.checkout');

        Route::get('/stripe/success', [StripeController::class, 'success'])
            ->name('stripe.success');

        Route::get('/stripe/failure', [StripeController::class, 'failure'])
            ->name('stripe.failure');

        Route::post('/become-a-vendor', [VendorController::class, 'store'])
            ->name('vendor.store');

        Route::post('/stripe/connect', [StripeController::class, 'connect'])
            ->name('stripe.connect')
            ->middleware(['role:' . \App\Enums\RolesEnum::Vendor->value]);
    });
});

// Order invoice route for Filament
Route::get('/admin/orders/{order}/invoice', function (Order $order) {
    // Check user permissions - should be authenticated admin or vendor that owns the order
    if (!auth()->check() ||
        (!auth()->user()->isAdmin() && $order->vendor_user_id !== auth()->id())) {
        abort(403);
    }

    // Load relationships
    $order->load(['user', 'orderItems.product', 'orderItems.variationOptions.variation_type', 'shippingAddress.country']);
    
    // Calculate subtotal
    $subtotal = 0;
    foreach ($order->orderItems as $item) {
        $subtotal += $item->price * $item->quantity;
    }
    $order->subtotal = $subtotal;

    // Generate invoice and return view
    return view('admin.orders.invoice', compact('order'));
})->name('filament.admin.resources.orders.invoice');

require __DIR__ . '/auth.php';
