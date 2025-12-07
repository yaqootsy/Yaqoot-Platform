<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';

    public static function labels()
    {
        return [
            self::Pending->value => 'بانتظار الدفع',    // أوضح من "معلّق"
            self::Paid->value => 'تم الدفع',           // أكثر وضوحًا وودية
            self::Failed->value => 'فشل الدفع',        // يوضح السبب ويشير للإجراء المطلوب
        ];
    }

    public static function colors()
    {
        return [
            'warning' => self::Pending->value,
            'success' => self::Paid->value,
            'danger' => self::Failed->value,
        ];
    }
}
