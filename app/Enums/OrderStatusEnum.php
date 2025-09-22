<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case Draft = 'draft';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public static function labels()
    {
        return [
            self::Draft->value => __('مسودة'),
            self::Paid->value => __('مدفوع'),
            self::Shipped->value => __('تم الشحن'),
            self::Delivered->value => __('تم التوصيل'),
            self::Cancelled->value => __('ملغي'),
        ];
    }

    public static function colors()
    {
        return [
            'gray' => self::Draft->value,
            'primary' => self::Paid->value,
            'warning' => self::Shipped->value,
            'success' => self::Delivered->value,
            'error' => self::Cancelled->value,
        ];
    }
}
