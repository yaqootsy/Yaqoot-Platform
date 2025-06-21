<?php

namespace App\Enums;

enum PermissinsEnum: string
{
    case ApproveVendors = 'ApproveVendors';
    case SellProducts = 'SellProducts';
    case BuyProducts = 'BuyProducts';
}
