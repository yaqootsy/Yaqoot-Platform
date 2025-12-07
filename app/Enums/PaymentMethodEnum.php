<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case Stripe = 'stripe';
    case COD = 'cod';

    public static function labels()
    {
        return [
            self::Stripe->value => 'سترايب',
            self::COD->value => 'دفع عند الاستلام',
        ];
    }

    public static function colors()
    {
        return [
            'success' => self::Stripe->value,
            'danger' => self::COD->value,
        ];
    }
}
