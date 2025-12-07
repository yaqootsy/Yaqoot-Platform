<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Resources\ShippingAddressResource;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutCompleted;
use App\Mail\NewOrderMail;
use App\Notifications\OrderStatusUpdated;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartService $cartService)
    {
        list($user, $defaultAddress) = $this->userShippingAddress();
        return Inertia::render('Cart/Index', [
            'cartItems' => $cartService->getCartItemsGrouped(),
            'addresses' => $user ? ShippingAddressResource::collection($user->shippingAddresses)->collection->toArray() : [],
            'shippingAddress' => $defaultAddress ? new ShippingAddressResource($defaultAddress) : null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product, CartService $cartService)
    {
        $request->mergeIfMissing([
            'quantity' => 1
        ]);

        $data = $request->validate([
            'option_ids' => ['nullable', 'array'],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);



        $productTotalQuantity = $product->getTotalQuantity($data['option_ids']);
        $cartQuantity = $cartService->getQuantity($product, $data['option_ids']);
        // Log::info('Cart debug', [
        //     'productTotalQuantity' => $productTotalQuantity,
        //     'cartQuantity' => $cartQuantity,
        //     'requestedQuantity' => $data['quantity'],
        // ]);
        if ($cartQuantity + $data['quantity'] > $productTotalQuantity) {
            $message = match ($productTotalQuantity - $cartQuantity) {
                0 => 'المنتج غير متوفر',
                1 => 'لم يتبق سوى قطعة واحدة في المخزون',
                default => 'لم يتبق سوى  ' . ($productTotalQuantity - $cartQuantity) . ' قطع في المخزون'
            };
            return back()->with('errorToast', $message);
        }

        $cartService->addItemToCart(
            $product,
            $data['quantity'],
            $data['option_ids'] ?: []
        );

        return back()->with('successToast', 'تمت إضافة المنتج إلى سلة التسوق بنجاح!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, CartService $cartService)
    {
        $request->validate([
            'quantity' => [
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($product, $request) {
                    $optionIds = $request->input('option_ids') ?: [];
                    $productTotalQuantity = $product->getTotalQuantity($optionIds);

                    if ($value > $productTotalQuantity) {
                        $fail("There are only {$productTotalQuantity} items left in stock");
                    }
                },
            ],
        ]);

        $optionIds = $request->input('option_ids') ?: []; // Get the option IDs (if applicable)
        $quantity = $request->input('quantity'); // Get the new quantity

        $cartService->updateItemQuantity($product->id, $quantity, $optionIds);

        return back()->with('successToast', 'تم تحديث الكمية');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product, CartService $cartService)
    {
        $optionIds = $request->input('option_ids');

        $cartService->removeItemFromCart($product->id, $optionIds);

        return back()->with('successToast', 'تمت إزالة المنتج من سلة التسوق.');
    }

    public function checkout(Request $request, CartService $cartService)
    {
        $paymentMethod = $request->input('payment_method', 'cod'); // 'stripe' or 'cod'

        // Only set Stripe API key when we actually need Stripe
        if ($paymentMethod === 'stripe') {
            \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
        }

        $vendorId = $request->input('vendor_id');

        $allCartItems = $cartService->getCartItemsGrouped();

        list($authUser, $defaultAddress) = $this->userShippingAddress();

        DB::beginTransaction();
        try {
            $checkoutCartItems = $allCartItems;
            if ($vendorId) {
                // If paying for a single vendor
                if (! isset($allCartItems[$vendorId])) {
                    throw new \Exception('Invalid vendor selected');
                }
                $checkoutCartItems = [$allCartItems[$vendorId]];
            }

            $orders = [];
            $lineItems = [];

            foreach ($checkoutCartItems as $item) {
                $user = $item['user'];
                $cartItems = $item['items'];

                // default payment_status = pending (for both stripe and cod)
                $initialPaymentStatus = PaymentStatusEnum::Pending->value;

                $order = Order::create([
                    'stripe_session_id' => null,
                    'payment_method' => $paymentMethod,
                    'payment_status' => $initialPaymentStatus,
                    'user_id' => $authUser->id,
                    'vendor_user_id' => $user['id'],
                    'total_price' => $item['totalPrice'],
                    'status' => OrderStatusEnum::Pending->value, // logistic status
                ]);

                // attach shipping address snapshot
                $tmpAddressData = $defaultAddress->toArray();
                $tmpAddressData['addressable_id'] = $order->id;
                $tmpAddressData['addressable_type'] = Order::class;
                unset($tmpAddressData['id']);
                $order->shippingAddress()->create($tmpAddressData);

                $orders[] = $order;

                foreach ($cartItems as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem['product_id'],
                        'quantity' => $cartItem['quantity'],
                        'price' => $cartItem['price'],
                        'variation_type_option_ids' => $cartItem['option_ids'],
                    ]);

                    // Prepare Stripe line items only when payment method is stripe
                    if ($paymentMethod === 'stripe') {
                        $description = collect($cartItem['options'])->map(function ($item) {
                            return "{$item['type']['name']}: {$item['name']}";
                        })->implode(', ');

                        $lineItem = [
                            'price_data' => [
                                'currency' => config('app.stripe_currency'),
                                'product_data' => [
                                    'name' => $cartItem['title'],
                                    'images' => [$cartItem['image']],
                                ],
                                'unit_amount' => (int) round($cartItem['price'] * 100),
                            ],
                            'quantity' => $cartItem['quantity'],
                        ];

                        if ($description) {
                            $lineItem['price_data']['product_data']['description'] = $description;
                        }

                        $lineItems[] = $lineItem;
                    }
                }
            }

            // If Stripe selected, create a single checkout session for all lineItems
            if ($paymentMethod === 'stripe') {
                $session = \Stripe\Checkout\Session::create([
                    'customer_email' => $authUser->email,
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => route('stripe.success', []) . "?session_id={CHECKOUT_SESSION_ID}",
                    'cancel_url' => route('stripe.failure', []),
                ]);

                // save session id (and if available payment_intent) to all orders
                foreach ($orders as $order) {
                    $order->stripe_session_id = $session->id;
                    // payment_intent may be available on session object; save as reference if present
                    if (isset($session->payment_intent) && $session->payment_intent) {
                        $order->payment_reference = $session->payment_intent;
                    }
                    $order->save();
                }

                foreach ($orders as $order) {
                    try {

                        if ($order->vendorUser?->email) {
                            Mail::to($order->vendorUser->email)->queue(new NewOrderMail($order));
                            Log::info('Vendor mail queued', ['order_id' => $order->id, 'vendor_email' => $order->vendorUser->email]);
                        }

                        if ($order->user?->email) {
                            Mail::to($order->user->email)->queue(new CheckoutCompleted(collect([$order])));
                            Log::info('Customer mail queued', ['order_id' => $order->id, 'customer_email' => $order->user->email]);
                        }
                    } catch (\Throwable $mailEx) {
                        Log::error('Mail queueing failed', [
                            'order_id' => $order->id,
                            'error' => $mailEx->getMessage()
                        ]);
                    }
                }



                DB::commit();

                return redirect($session->url);
            }

            // If COD selected, do NOT create a Stripe session.
            // Keep payment_status = pending (we will set to 'paid' when COD is collected, via another flow)
            foreach ($orders as $order) {
                try {
                    // اشعار التاجر بوجود طلب جديد
                    if ($order->vendorUser?->email) {
                        Mail::to($order->vendorUser->email)->queue(new NewOrderMail($order));
                        Log::info('Vendor mail queued', ['order_id' => $order->id, 'vendor_email' => $order->vendorUser->email]);
                    }

                    // اشعار الزبون بأن طلبه بانتظار التأكيد
                    if ($order->user?->email) {
                        $changes = [];
                        $changes['status'] = $order->status;
                        $order->user->notify(new OrderStatusUpdated($order, $changes));
                    }

                    // لو أردت لاحقًا للزبون
                    // if ($order->user?->email) {
                    //     Mail::to($order->user->email)->queue(new CheckoutCompleted(collect([$order])));
                    //     Log::info('Customer mail queued', ['order_id' => $order->id, 'customer_email' => $order->user->email]);
                    // }
                } catch (\Throwable $mailEx) {
                    Log::error('Mail queueing failed', [
                        'order_id' => $order->id,
                        'error' => $mailEx->getMessage()
                    ]);
                }
            }


            DB::commit();

            // Clear cart after successful DB commit
            $cartService->clearCart();

            return redirect()->route('orders.index')->with('success', 'تم إنشاء الطلب بنجاح. طريقة الدفع: الدفع عند الاستلام.');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return back()->with('error', $e->getMessage() ?: 'Something went wrong');
        }
    }


    public function updateShippingAddress(Address $address)
    {
        if (!$address->belongs(auth()->user())) {
            abort(403, "Unauthorized");
        }
        // Update the shipping address in session
        session()->put('shipping_address_id', $address->id);
        return back();
    }

    /**
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function userShippingAddress(): array
    {
        $user = auth()->user();
        if (!$user) {
            return [null, null];
        }
        // Get shipping address from session
        $shippingAddressId = session()->get('shipping_address_id');
        if ($shippingAddressId) {
            $defaultAddress = $user->shippingAddresses->find($shippingAddressId);
        } else {
            $defaultAddress = $user->shippingAddress;
        }
        return array($user, $defaultAddress);
    }
}
