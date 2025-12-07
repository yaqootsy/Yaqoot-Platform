<?php

namespace App\Filament\Resources\VendorResource\RelationManagers;

use App\Models\VendorPendingChange;
use App\Enums\ChangesStatusEnum;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PendingChangesRelationManager extends RelationManager
{
    // العلاقة في موديل Vendor: hasMany(VendorPendingChange::class, 'vendor_id', 'user_id')
    protected static string $relationship = 'pendingChanges';
    protected static ?string $recordTitleAttribute = 'field';
    // <-- هنا تتحكم في العنوان المعروض للـ RelationManager
    protected static ?string $label = 'التغييرات المعلقة';        // عنوان مفرد (إن احتجت)
    protected static ?string $pluralLabel = 'التغييرات المعلقة'; // عنوان جمع

    // ملاحظة: يجب أن يكون non-static حسب إصدار Filament عندك
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('field')
                    ->label('الحقل')
                    ->getStateUsing(fn($record) => $record->field == 'cover_image' ? 'صورة الغلاف' : 'اسم المتجر')
                    ->sortable(),
                TextColumn::make('old_text')
                    ->label('القيمة الحالية')
                    ->limit(80)
                    ->wrap()
                    ->getStateUsing(fn($record) => $record->field !== 'cover_image' ? $record->old_value : null),

                TextColumn::make('new_text')
                    ->label('القيمة المقترحة')
                    ->limit(80)
                    ->wrap()
                    ->getStateUsing(fn($record) => $record->field !== 'cover_image' ? $record->new_value : null),

                ImageColumn::make('old_image')
                    ->label('الصورة الحالية')
                    ->size(80)
                    ->getStateUsing(function ($record) {
                        if ($record->field !== 'cover_image') {
                            return null;
                        }

                        $media = $record->vendor->getFirstMedia('cover_images');
                        if (!$media) {
                            return null;
                        }

                        // تحقق من وجود thumb
                        return in_array('thumb', $media->getGeneratedConversions()->toArray())
                            ? $media->getUrl('thumb')
                            : $media->getUrl();
                    })
                    ->url(function ($record) {
                        $media = $record->vendor->getFirstMedia('cover_images');
                        return $media?->getUrl();
                    })
                    ->openUrlInNewTab(),

                ImageColumn::make('new_image')
                    ->label('الصورة الجديدة')
                    ->size(80)
                    ->getStateUsing(function ($record) {
                        if ($record->field === 'cover_image' && $record->new_value) {
                            $filename = basename($record->new_value);
                            $path = "vendor_pending/{$record->vendor_id}/cover_image/{$filename}";

                            return Storage::exists($path)
                                ? route('vendor.pending.file', [
                                    'vendor' => $record->vendor_id,
                                    'field' => 'cover_image',
                                    'filename' => $filename,
                                ])
                                : null;
                        }

                        return null;
                    })
                    ->url(function ($record) {
                        if ($record->field === 'cover_image' && $record->new_value) {
                            $filename = basename($record->new_value);
                            $path = "vendor_pending/{$record->vendor_id}/cover_image/{$filename}";

                            return Storage::exists($path)
                                ? route('vendor.pending.file', [
                                    'vendor' => $record->vendor_id,
                                    'field' => 'cover_image',
                                    'filename' => $filename,
                                ])
                                : null;
                        }

                        return null;
                    })
                    ->openUrlInNewTab(),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn($state) => ChangesStatusEnum::from($state)->label())
                    ->colors(ChangesStatusEnum::colors())
                    ->sortable(),
                TextColumn::make('created_at')->label('تاريخ الطلب')->dateTime()->sortable(),
                TextColumn::make('reviewed_at')->label('تاريخ المراجعة')->dateTime()->sortable(),
                TextColumn::make('reviewed_by')->label('تمت المراجعة بواسطة')->formatStateUsing(fn($state) => $state ?: '—'),
            ])
            // <-- هنا تتحكم في نصوص حالة الخلو (عندما لا توجد تغييرات)
            ->emptyStateHeading('لا توجد تغييرات معلقة')
            ->emptyStateDescription('لا توجد أي تغييرات بانتظار المراجعة لهذا البائع.')
            ->heading('التغيرات المعلقة')

            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('موافقة')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->action(function (Model $record) {
                        /** @var VendorPendingChange $record */
                        $vendor = $record->vendor;

                        if (! $vendor) {
                            throw new \Exception('Vendor not found for pending change ID: ' . $record->id);
                        }

                        DB::beginTransaction();
                        try {
                            // --- حقل اسم المتجر ---
                            if ($record->field === 'store_name') {
                                $old = $vendor->store_name;
                                $vendor->store_name = $record->new_value;
                                $vendor->save();

                                if ($old !== $vendor->store_name) {
                                    \App\Models\Product::where('created_by', $vendor->user_id)
                                        ->lazyById(500)
                                        ->each(function ($product) {
                                            dispatch(function () use ($product) {
                                                try {
                                                    $product->searchable();
                                                } catch (\Exception $e) {
                                                    Log::error("Product reindex failed: " . $e->getMessage());
                                                }
                                            });
                                        });
                                }
                            } elseif (in_array($record->field, ['cover_image', 'id_card', 'trade_license'])) {
                                $relativePath = $record->new_value;
                                $absolutePath = storage_path('app/private/' . $relativePath);
                                if (file_exists($absolutePath)) {
                                    $collection = $record->field === 'cover_image' ? 'cover_images' : $record->field;
                                    $vendor->clearMediaCollection($collection);
                                    $vendor->addMedia($absolutePath)
                                        ->preservingOriginal()
                                        ->toMediaCollection($collection);
                                    unlink($absolutePath);
                                } else {
                                    Log::warning("Temp file for pending change not found: {$absolutePath}");
                                }
                            } else {
                                $field = $record->field;
                                $vendor->{$field} = $record->new_value;
                                $vendor->save();
                            }
                            $record->status = 'approved';
                            $record->reviewed_by = auth()->id();
                            $record->reviewed_at = now();
                            $record->save();
                            $hasPending = $vendor->pendingChanges()->where('status', 'pending')->exists();
                            if (! $hasPending) {
                                $vendor->status = \App\Enums\VendorStatusEnum::Approved->value;
                                $vendor->save();
                            }
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Log::error('Approve pending change failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                            throw $e;
                        }
                    })
                    ->visible(fn($record) => $record->status === 'pending'),





                Action::make('reject')
                    ->label('رفض')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->action(function (Model $record) {
                        // حذف الملف المؤقت إن كان موجودًا
                        if (in_array($record->field, ['cover_image']) && $record->new_value) {
                            $tempPath = storage_path('app/private/' . $record->new_value);
                            if (file_exists($tempPath)) {
                                unlink($tempPath);
                            }
                        }

                        $record->status = 'rejected';
                        $record->reviewed_by = auth()->id();
                        $record->reviewed_at = now();
                        $record->save();

                        $vendor = $record->vendor;
                        $hasPending = $vendor ? $vendor->pendingChanges()->where('status', 'pending')->exists() : false;
                        if ($vendor && ! $hasPending && $vendor->status === \App\Enums\VendorStatusEnum::Pending->value) {
                            $vendor->status = \App\Enums\VendorStatusEnum::Approved->value;
                            $vendor->save();
                        }
                    })
                    ->visible(fn($record) => $record->status === 'pending'),

                DeleteAction::make()
                    ->label('حذف')
                    ->action(function (Model $record) {
                        // حذف الملف المؤقت إذا موجود
                        if (in_array($record->field, ['cover_image']) && $record->new_value) {
                            $tempPath = storage_path('app/private/' . $record->new_value);
                            if (file_exists($tempPath)) {
                                unlink($tempPath);
                            }
                        }

                        $record->delete();
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }
}
