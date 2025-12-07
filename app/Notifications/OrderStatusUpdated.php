<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected $order, protected $changes = [])
    {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject("تحديث بخصوص طلبك رقم {$this->order->id}")
            ->greeting("مرحباً {$notifiable->name} 👋،")
            ->line("يسعدنا إبلاغك بآخر المستجدات حول طلبك رقم {$this->order->id}.");

        // ✅ حالة الطلب
        if (isset($this->changes['status'])) {
            $status = strtolower($this->changes['status']);

            switch ($status) {
                case 'pending':
                    $message->line("لقد تم تسجيل طلبك وهو الآن بانتظار تأكيد التاجر.");
                    break;

                case 'processing':
                    $message->line("تم استلام طلبك ويجري حالياً تجهيزه بعناية ✨.");
                    break;

                case 'shipped':
                    $message->line("تم شحن طلبك وهو الآن في الطريق إليك 🚚. نتمنى أن يصلك بسرعة وسلامة.");
                    break;

                case 'delivered':
                    $message->line("تم تسليم طلبك بنجاح ✅. شكراً لثقتك بنا ونتمنى أن تستمتع بمشترياتك!");
                    break;

                case 'cancelled':
                    $cancelledBy = $this->order->cancelled_by === 'customer' ? 'من طرفك' : 'من طرف التاجر';
                    $message->line("تم إلغاء طلبك {$cancelledBy} بتاريخ {$this->order->cancelled_at}. نأسف لذلك ونتمنى خدمتك بشكل أفضل في المرات القادمة.");
                    break;

                default:
                    $message->line("تم تحديث حالة طلبك إلى: {$this->changes['status']}.");
            }
        }

        // ✅ كود التتبع
        if (!empty($this->changes['tracking_code'])) {
            $trackingCode = $this->changes['tracking_code'];
            $message->line("تمت إضافة كود تتبع خاص بطلبك: **{$trackingCode}**");
            $message->line("يمكنك استخدام هذا الكود لمتابعة شحنتك لدى شركة التوصيل بسهولة.");
        }

        // ✅ زر تفاصيل الطلب
        $orderUrl = url("/orders/{$this->order->id}");
        $message->action('عرض تفاصيل الطلب', $orderUrl);

        $message->line('💙 شكراً لتسوقك معنا عبر ' . config('app.name') . '. نحن دائماً بانتظارك!');
        
        $message->salutation(" "); // يزيل Regards

        return $message;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'changes' => $this->changes,
        ];
    }
}
