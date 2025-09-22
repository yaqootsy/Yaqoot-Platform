<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Enums\RolesEnum;

class AdminDashboardStats extends BaseWidget
{
    // protected static string $view = 'filament.widgets.stats-overview';

    // استخدم public static كما في parent
    public static function canView(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        return auth()->check() && auth()->user()->hasRole(RolesEnum::Admin);
    }

    protected function getStats(): array
    {
        return [
            Stat::make('عدد المستخدمين', User::count())
                ->description('جميع المستخدمين')
                ->color('primary'),

            Stat::make('عدد التجار', User::role(RolesEnum::Vendor->value)->count())
                ->description('عدد حسابات التاجر')
                ->color('success'),

            Stat::make('عدد المنتجات', Product::count())
                ->description('جميع المنتجات في الموقع')
                ->color('warning'),

            Stat::make('عدد الطلبات الكلي', Order::count())
                ->description('جميع الطلبات')
                ->color('danger'),

            Stat::make('الطلبات اليوم', Order::whereDate('created_at', now())->count())
                ->description('عدد الطلبات اليوم')
                ->color('primary'),

            Stat::make('إيرادات اليوم', Order::whereDate('created_at', now())->sum('total_price'))
                ->description('إجمالي الإيرادات اليوم')
                ->color('success'),

            Stat::make('إيرادات الشهر', Order::whereMonth('created_at', now())->sum('total_price'))
                ->description('إجمالي الإيرادات لهذا الشهر')
                ->color('warning'),

            Stat::make('آخر 5 طلبات', Order::latest()->take(5)->count())
                ->description('عدد آخر 5 طلبات')
                ->color('primary'),
        ];
    }
}
