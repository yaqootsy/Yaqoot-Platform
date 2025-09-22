<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Resources\OrderViewResource;
use App\Mail\CheckoutCompleted;
use App\Mail\NewOrderMail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class StripeController extends Controller
{
    public function success(Request $request)
    {
        $user = auth()->user();
        $session_id = $request->get('session_id');
        $orders = Order::where('stripe_session_id', $session_id)
            ->get();

        if ($orders->count() === 0) {
            abort(404);
        }

        foreach ($orders as $order) {
            if ($order->user_id !== $user->id) {
                abort(403);
            }
        }

        return Inertia::render('Stripe/Success', [
            'orders' => OrderViewResource::collection($orders)->collection->toArray(),
        ]);
    }

    public function failure() {}

    public function webhook(Request $request)
    {
        // انشاء عميل Stripe
        $stripe = new \Stripe\StripeClient(config('app.stripe_secret_key'));
        $endpoint_secret = config('app.stripe_webhook_secret');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        // التحقق من صحة الـ webhook signature
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            \Log::error('Stripe webhook - Invalid payload: ' . $e->getMessage());
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            \Log::error('Stripe webhook - Invalid signature: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // التعامل بحسب نوع الحدث
        switch ($event->type) {
            /**
             * عند اكتمال جلسة Checkout نحتاج:
             * - محاولة حجز/خصم الكمية ضمن ترانزاكشن مع lockForUpdate
             * - عند نجاح الحجز: وضع حالة الطلب Paid وإرسال الإشعارات/مسح من السلة
             * - عند فشل الحجز: وضع حالة Failed ومحاولة عمل Refund إذا تم الدفع
             */
            case 'checkout.session.completed':
                $session = $event->data->object;
                $sessionId = $session['id'] ?? null;
                $paymentIntent = $session['payment_intent'] ?? null;

                if (!$sessionId) {
                    \Log::warning('Stripe webhook: checkout.session.completed بدون session id');
                    break;
                }

                // جلب الطلبات المرتبطة بهذه الجلسة (قد تكون أكثر من طلب لعدة بائعين)
                $orders = \App\Models\Order::query()
                    ->with(['orderItems.product.variations', 'vendorUser', 'user'])
                    ->where('stripe_session_id', $sessionId)
                    ->get();

                if ($orders->isEmpty()) {
                    \Log::warning("Stripe webhook: لا يوجد طلبات مرتبطة بالجلسة {$sessionId}");
                    break;
                }

                foreach ($orders as $order) {
                    // idempotency: إذا كان الطلب مدفوع مسبقاً نتخطاه
                    if ($order->status === \App\Enums\OrderStatusEnum::Paid) {
                        \Log::info("Stripe webhook: الطلب {$order->id} مُعالج مسبقاً (Paid) - تجاهل.");
                        continue;
                    }

                    try {
                        // ترانزاكشن تحمي من السباق على المخزون
                        \DB::transaction(function () use ($order, $paymentIntent) {
                            $processedProductIds = [];

                            // نفحص كل items ونخصم من المخزون مع عمل lockForUpdate
                            foreach ($order->orderItems as $orderItem) {
                                /** @var \App\Models\Product $product */
                                $product = $orderItem->product;
                                $options = $orderItem->variation_type_option_ids;

                                if ($options && is_array($options) && count($options) > 0) {
                                    // قفل كل الـ variations للمنتج مؤقتًا ثم البحث عن التطابق الدقيق للمصفوفة
                                    $variations = $product->variations()->lockForUpdate()->get();

                                    // مطابقة ترتيب القيم بعد فرزها
                                    $sortedTarget = $options;
                                    sort($sortedTarget);

                                    $variation = $variations->first(function ($v) use ($sortedTarget) {
                                        $vo = $v->variation_type_option_ids;
                                        if (!is_array($vo)) return false;
                                        $copy = $vo;
                                        sort($copy);
                                        return $copy === $sortedTarget;
                                    });

                                    if (!$variation) {
                                        throw new \Exception("الاختيار المطلوب غير موجود للمنتج #{$product->id}");
                                    }

                                    // إذا كانت الكمية null => نعتبرها غير محدودة (لا نخصم)
                                    if ($variation->quantity !== null) {
                                        if ($variation->quantity < $orderItem->quantity) {
                                            throw new \Exception("الكمية غير كافية للمنتج {$product->title}");
                                        }

                                        $variation->quantity -= $orderItem->quantity;
                                        if ($variation->quantity < 0) {
                                            $variation->quantity = 0;
                                        }
                                        $variation->save();
                                    }

                                    $processedProductIds[] = $product->id;
                                } else {
                                    // قفل صف المنتج نفسه
                                    $productForUpdate = \App\Models\Product::where('id', $product->id)->lockForUpdate()->first();

                                    if (!$productForUpdate) {
                                        throw new \Exception("المنتج غير موجود #{$product->id}");
                                    }

                                    if ($productForUpdate->quantity !== null) {
                                        if ($productForUpdate->quantity < $orderItem->quantity) {
                                            throw new \Exception("الكمية غير كافية للمنتج {$product->title}");
                                        }

                                        $productForUpdate->quantity -= $orderItem->quantity;
                                        if ($productForUpdate->quantity < 0) {
                                            $productForUpdate->quantity = 0;
                                        }
                                        $productForUpdate->save();
                                    }

                                    $processedProductIds[] = $product->id;
                                }
                            } // end foreach orderItems

                            // إذا وصلنا هنا فالخصم ناجح لجميع عناصر الطلب، نحدّث حالة الطلب
                            $order->payment_intent = $paymentIntent;
                            $order->status = \App\Enums\OrderStatusEnum::Paid;
                            $order->save();

                            // حذف عناصر السلة المتعلقة بهذا الطلب للمستخدم
                            if (!empty($processedProductIds)) {
                                \App\Models\CartItem::query()
                                    ->where('user_id', $order->user_id)
                                    ->whereIn('product_id', $processedProductIds)
                                    ->where('saved_for_later', false)
                                    ->delete();
                            }
                        }); // end transaction

                        // بعد اكتمال الترانزاكشن نرسل الإشعارات خارج الترانزاكشن
                        \Mail::to($order->vendorUser)->send(new \App\Mail\NewOrderMail($order));
                        \Mail::to($order->user)->send(new \App\Mail\CheckoutCompleted([$order]));
                    } catch (\Exception $e) {
                        // في حال فشل الحجز (لأن شخصًا آخر سبقه مثلاً) نعلّم الطلب بالفشل ونحاول رد المال
                        \Log::warning("Stripe webhook: فشل معالجة الطلب {$order->id} - السبب: " . $e->getMessage());

                        // وضع حالة الطلب Failed
                        $order->status = \App\Enums\OrderStatusEnum::Failed;
                        $order->save();

                        // محاولة عمل Refund عبر Stripe إذا كان لدينا payment_intent
                        if (!empty($paymentIntent)) {
                            try {
                                $refund = $stripe->refunds->create([
                                    'payment_intent' => $paymentIntent,
                                ]);
                                \Log::info("Stripe webhook: تم إنشاء Refund للطلب {$order->id} - refund id: " . ($refund['id'] ?? 'n/a'));
                            } catch (\Exception $refundEx) {
                                \Log::error("Stripe webhook: فشل إنشاء Refund للطلب {$order->id} - السبب: " . $refundEx->getMessage());
                                // هنا يمكنك إشعار الدعم أو حفظ سجل للتعامل اليدوي
                            }
                        }

                        // يمكن هنا إرسال إشعار للبائع أو للمشتري حول فشل الطلب وكونه سيتم رد المبلغ
                    }
                } // end foreach orders

                break;

            /**
                 * حالة charge.updated: نحسب العمولات ونعالجها (مماثل للمنطق السابق لديك)
                 * قد ترغب في حفظ حسابات الرسوم بعد أن يتم تسوية الـ balance transaction.
                 */
            case 'charge.updated':
                try {
                    $charge = $event->data->object;
                    $transactionId = $charge['balance_transaction'] ?? null;
                    $paymentIntent = $charge['payment_intent'] ?? null;

                    if ($transactionId && $paymentIntent) {
                        $balanceTransaction = $stripe->balanceTransactions->retrieve($transactionId);
                        $totalAmount = $balanceTransaction['amount'] ?? 0;

                        $stripeFee = 0;
                        foreach ($balanceTransaction['fee_details'] ?? [] as $fee_detail) {
                            if (($fee_detail['type'] ?? '') === 'stripe_fee') {
                                $stripeFee += $fee_detail['amount'] ?? 0;
                            }
                        }

                        $platformFeePercent = config('app.platform_fee_pct', 0);

                        $ordersToUpdate = \App\Models\Order::where('payment_intent', $paymentIntent)->get();
                        foreach ($ordersToUpdate as $o) {
                            $vendorShare = $totalAmount > 0 ? ($o->total_price / $totalAmount) : 0;

                            $o->online_payment_commission = $vendorShare * $stripeFee;
                            $o->website_commission = ($o->total_price - $o->online_payment_commission) / 100 * $platformFeePercent;
                            $o->vendor_subtotal = $o->total_price - $o->online_payment_commission - $o->website_commission;
                            $o->save();

                            // إرسال إشعار للبائع
                            \Mail::to($o->vendorUser)->send(new \App\Mail\NewOrderMail($o));
                        }

                        if ($ordersToUpdate->count()) {
                            \Mail::to($ordersToUpdate->first()->user)->send(new \App\Mail\CheckoutCompleted($ordersToUpdate));
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error("Stripe webhook - charge.updated processing failed: " . $e->getMessage());
                }
                break;

            default:
                \Log::info('Stripe webhook: استلمنا حدث غير معروف: ' . $event->type);
                break;
        }

        // Stripe يتوقع 2xx عند النجاح
        return response('', 200);
    }


    public function connect()
    {
        if (!auth()->user()->getStripeAccountId()) {
            auth()->user()->createStripeAccount(['type' => 'express']);
        }

        if (!auth()->user()->isStripeAccountActive()) {
            return redirect(auth()->user()->getStripeAccountLink());
        }

        return back()->with('success', 'Your account is already connected.');
    }
}
