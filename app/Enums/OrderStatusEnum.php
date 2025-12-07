<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public static function labels()
    {
        return [
            self::Pending->value => 'طلب جديد بانتظار التأكيد',
            self::Processing->value => 'جارٍ تجهيز الطلب', 
            self::Shipped->value => 'تم شحن الطلب',
            self::Delivered->value => 'تم تسليم الطلب',
            self::Cancelled->value => 'تم إلغاء الطلب', 
        ];
    }

    public static function colors()
    {
        return [
            'warning' => self::Pending->value,
            'info' => self::Processing->value,
            'primary' => self::Shipped->value,
            'success' => self::Delivered->value,
            'danger' => self::Cancelled->value,
        ];
    }
}
