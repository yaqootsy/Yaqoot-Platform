<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Mail\CheckoutCompleted;
use App\Mail\NewOrderMail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CodController extends Controller
{
    /**
     * Mark a COD order as collected (payment received at delivery).
     *
     * Authorization:
     * - The vendor who owns the order OR the order owner (customer) OR any user who can('collect-cod')
     *   can call this. Adjust authorization logic to fit your app roles (delivery agents, admins...).
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function collect(Request $request, Order $order)
    {
        $user = auth()->user();

        // Basic authorization:
        if (! (
            $user->id === $order->vendor_user_id ||        // vendor
            $user->id === $order->user_id ||               // customer (optional)
            $user->can('collect-cod')                      // custom ability (define via Gate/Policy)
        )) {
            abort(403, 'Unauthorized');
        }

        // Ensure this order is COD (optional, but recommended)
        if ($order->payment_method !== 'cod') {
            return response()->json([
                'status' => 'error',
                'message' => 'This order is not marked as COD.'
            ], 400);
        }

        // Idempotency: if already marked paid, return ok
        if ($order->payment_status === PaymentStatusEnum::Paid->value) {
            return response()->json([
                'status' => 'success',
                'message' => 'Payment already marked as collected.',
            ], 200);
        }

        DB::beginTransaction();
        try {
            // 1) Mark payment fields
            $order->payment_status = PaymentStatusEnum::Paid->value;
            $order->paid_at = Carbon::now();
            $order->cod_collected_at = Carbon::now();
            $order->cod_collector_id = $user->id;

            // 2) compute commissions for COD (no stripe fee)
            //    online_payment_commission = 0
            //    website_commission = platform_pct% of total_price
            $platformFeePercent = (float) config('app.platform_fee_pct', 0);
            $order->online_payment_commission = 0;
            $order->website_commission = ($order->total_price / 100) * $platformFeePercent;
            $order->vendor_subtotal = $order->total_price - $order->online_payment_commission - $order->website_commission;

            $order->save();

            // 3) Reduce product / variation stock similar to Stripe webhook handling
            $productIdsToRemoveFromCart = [];

            $order->load('orderItems.product'); // eager load
            foreach ($order->orderItems as $orderItem) {
                /** @var OrderItem $orderItem */
                $options = $orderItem->variation_type_option_ids;
                $product = $orderItem->product;

                // Collect ids for later cart cleanup
                $productIdsToRemoveFromCart[] = $orderItem->product_id;

                if ($options) {
                    sort($options);
                    $variation = $product->variations()
                        ->where('variation_type_option_ids', $options)
                        ->first();

                    if ($variation && $variation->quantity !== null) {
                        $variation->quantity = max(0, $variation->quantity - $orderItem->quantity);
                        $variation->save();
                    }
                } else if ($product->quantity !== null) {
                    $product->quantity = max(0, $product->quantity - $orderItem->quantity);
                    $product->save();
                }
            }

            // 4) Remove purchased items from user's cart (if any remain)
            if (! empty($productIdsToRemoveFromCart)) {
                CartItem::query()
                    ->where('user_id', $order->user_id)
                    ->whereIn('product_id', $productIdsToRemoveFromCart)
                    ->where('saved_for_later', false)
                    ->delete();
            }

            // 5) Notify vendor(s) and customer
            // If you have multiple orders per checkout you might send per-order vendor mail.
            Mail::to($order->vendorUser)->send(new NewOrderMail($order));
            Mail::to($order->user)->send(new CheckoutCompleted(collect([$order])));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'COD payment marked as collected.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('COD collect error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to mark COD as collected.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
