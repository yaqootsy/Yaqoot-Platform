<?php

namespace App\Filament\Pages;

use App\Enums\RolesEnum;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class VendorSettings extends Page implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected ?string $heading = 'إعدادات المتجر';
    protected static string $view = 'filament.pages.vendor-settings';
    protected static ?string $navigationLabel = 'إعدادات المتجر';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?int $navigationSort = 100;


    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole(RolesEnum::Vendor->value);
    }
    // تأكد أن الصفحة تظهر فقط للبائع
    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole(RolesEnum::Vendor->value);
    }

    // ربط الحالة
    public array $data = [];

    public function mount(): void
    {
        $vendor = $this->getVendor();

        $this->data = [
            'is_temporarily_closed' => (bool) $vendor->is_temporarily_closed,
            'temporary_close_until' => $vendor->temporary_close_until ? $vendor->temporary_close_until->toDateString() : null,
        ];

        // ملء الفورم (اختياري)
        $this->form->fill($this->data);
    }

    // تعريف مخطط الفورم وربطه ب $data
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('is_temporarily_closed')
                    ->label('إغلاق المتجر مؤقتاً')
                    ->reactive(),

                Forms\Components\DatePicker::make('temporary_close_until')
                    ->label('تاريخ العودة (اختياري)')
                    ->nullable()
                    ->minDate(now()->toDateString())
                    ->visible(fn(callable $get): bool => (bool) $get('is_temporarily_closed'))
                    ->extraAttributes(['class' => 'max-w-xs']), // التحكم بالعرض
            ])
            ->statePath('data');
    }


    public function save(): void
    {
        $data = $this->form->getState();
        $vendor = $this->getVendor();

        if (empty($data['is_temporarily_closed'])) {
            $data['temporary_close_until'] = null;
        }

        $vendor->update($data);

        Notification::make()
            ->title('تم حفظ الإعدادات')
            ->success()
            ->send();

        $this->data = $this->form->getState();
    }

    protected function getVendor(): Vendor
    {
        $vendor = auth()->user()?->vendor;

        if (! $vendor) {
            abort(403, 'لا يوجد متجر مرتبط بالمستخدم.');
        }

        return $vendor;
    }
}
