<?php

namespace App\Enums;

enum VendorStatusEnum: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'مسودة',
            self::Pending => 'معلق',
            self::Approved => 'موافق عليه',
            self::Rejected => 'مرفوض',
        };
    }

    public static function labels(): array
    {
        return [
            self::Draft->value => 'مسودة',
            self::Pending->value => 'معلق',
            self::Approved->value => 'موافق عليه',
            self::Rejected->value => 'مرفوض',
        ];
    }

    public static function colors(): array
    {
        return [
            'gray'  => self::Draft->value, 
            'warning'    => self::Pending->value, 
            'success' => self::Approved->value,
            'danger' => self::Rejected->value,
        ];
    }
}
