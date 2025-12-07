<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function beforeFill(): void
    {
        // منع الوصول للطلبات الملغاة
        if ($this->getRecord()->status === 'cancelled') {
            Notification::make()
                ->title('لا يمكن تعديل الطلب')
                ->body('هذا الطلب ملغى ولا يمكن التعديل عليه.')
                ->danger()
                ->send();

            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('حذف'),
        ];
    }

    protected function afterSave(): void
    {
        $order = $this->record;
        $changes = [];

        // إذا تغيّرت الحالة
        if ($order->wasChanged('status')) {
            $changes['status'] = $order->status;

            // لو الحالة الجديدة ملغي → اعتبرها إلغاء من التاجر (vendor)
            if ($order->status === 'cancelled') {
                $order->updateQuietly([
                    'payment_status' => 'failed',
                    'cancelled_by' => 'vendor',
                    'cancelled_at' => now(),
                ]);
            }
        }

        // إذا تغيّر كود التتبع
        if ($order->wasChanged('tracking_code') && $order->tracking_code) {
            $changes['tracking_code'] = $order->tracking_code;

            $order->tracking_code_added_at = Carbon::now();
            $order->saveQuietly();
        }

        if (!empty($changes)) {
            $order->user->notify(new OrderStatusUpdated($order, $changes));

            Notification::make()
                ->title('تم إعلام العميل')
                ->body('تم إعلام العميل بتحديث الطلب.')
                ->success()
                ->send();
        }
    }
}
