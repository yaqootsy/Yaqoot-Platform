<?php

namespace App\Filament\Resources\VendorResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Enums\RolesEnum;

class VendorStats extends BaseWidget
{
    // protected static string $view = 'filament.widgets.stats-overview';

    public static function canView(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        return auth()->check() && auth()->user()->hasRole(RolesEnum::Vendor);
    }


    protected function getStats(): array
    {
        $vendorId = Auth::id();

        return [
            Stat::make('منتجاتك', Product::where('created_by', $vendorId)->count())
                ->description('عدد المنتجات الخاصة بك')
                ->color('primary'),

            Stat::make('الطلبات الكلية', Order::where('vendor_user_id', $vendorId)->count())
                ->description('جميع الطلبات الخاصة بك')
                ->color('success'),

            Stat::make('الطلبات اليوم', Order::where('vendor_user_id', $vendorId)->whereDate('created_at', now())->count())
                ->description('عدد الطلبات اليوم')
                ->color('warning'),

            Stat::make('إيرادات اليوم', Order::where('vendor_user_id', $vendorId)->whereDate('created_at', now())->sum('total_price'))
                ->description('إجمالي الإيرادات اليوم')
                ->color('primary'),

            Stat::make('إيرادات الشهر', Order::where('vendor_user_id', $vendorId)->whereMonth('created_at', now())->sum('total_price'))
                ->description('إجمالي الإيرادات لهذا الشهر')
                ->color('success'),

            Stat::make('آخر 5 طلبات', Order::where('vendor_user_id', $vendorId)->latest()->take(5)->count())
                ->description('عدد آخر 5 طلبات الخاصة بك')
                ->color('warning'),
        ];
    }
}
