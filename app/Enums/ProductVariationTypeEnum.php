<?php

namespace App\Enums;

enum ProductVariationTypeEnum: string
{
    case Select = 'Select';
    case Radio = 'Radio';
    case Image = 'Image';

    public static function labels(): array
    {
        return [
            self::Select->value => 'قائمة اختيار',
            self::Radio->value => 'زر اختيار',
            self::Image->value => 'صورة',
        ];
    }
}
