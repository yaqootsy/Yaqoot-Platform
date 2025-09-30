<?php

namespace App\Filament\Resources;

use App\Enums\RolesEnum;
use App\Enums\VendorStatusEnum;
use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers\PendingChangesRelationManager;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Forms\Components\MapLocationPicker;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'بائع';

    protected static ?string $pluralModelLabel = 'البائعين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('User Details')
                    ->label('تفاصيل المستخدم')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                    ])
                    ->relationship('user'),

                Forms\Components\Fieldset::make('Vendor Details')
                    ->label('تفاصيل البائع')
                    ->schema([
                        // اسم المتجر الحالي (عرض فقط)
                        Forms\Components\TextInput::make('store_name')
                            ->label('اسم المتجر الحالي')
                            ->disabled()
                            ->dehydrated(false),

                        // Forms\Components\Placeholder::make('pending_changes')
                        //     ->label('التغييرات المعلقة')
                        //     ->content(function ($record) {
                        //         if (! $record) {
                        //             return new HtmlString('—');
                        //         }

                        //         $pending = $record->pendingChanges()->where('status', 'pending')->get();
                        //         if ($pending->isEmpty()) {
                        //             return new HtmlString('لا توجد تغييرات معلقة.');
                        //         }

                        //         $html = '<ul class="text-sm space-y-1">';
                        //         foreach ($pending as $p) {
                        //             // تأمين القيمة: نقتصر على نص مختصر مهرب لمنع XSS
                        //             $val = e(Str::limit($p->new_value, 80));
                        //             $time = $p->created_at ? $p->created_at->format('Y-m-d H:i') : '';
                        //             $field = e($p->field);
                        //             $html .= "<li><strong>{$field}</strong>: {$val} <span class='text-gray-500'>({$time})</span></li>";
                        //         }
                        //         $html .= '</ul>';

                        //         // إرجاع HtmlString ليتم عرضه كـ HTML
                        //         return new HtmlString($html);
                        //     })
                        //     ->dehydrated(false)
                        //     ->columnSpan(2),

                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options(VendorStatusEnum::labels())
                            ->required(),

                        Forms\Components\Textarea::make('store_address')
                            ->label('عنوان المتجر')
                            ->columnSpan(2),

                        MapLocationPicker::make('coordinates')
                            ->label('الموقع')
                            ->default(fn($record) => [
                                'latitude' => $record?->latitude ?? 32.5,
                                'longitude' => $record?->longitude ?? 36.1,
                            ])
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record) {
                                    $component->state([
                                        'latitude' => $record->latitude,
                                        'longitude' => $record->longitude,
                                    ]);
                                }
                            })
                            ->dehydrated(false)
                            ->columnSpan(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('store_name')
                    ->label('اسم المتجر')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('cover_image')
                    ->label('صورة الغلاف')
                    // ->size(80)
                    ->getStateUsing(fn($record) => $record->getFirstMedia('cover_images')?->getUrl())
                    ->extraAttributes(['style' => 'height:auto; width:auto; object-fit:contain;'])
                    ->url(fn($record) => $record->getFirstMedia('cover_images')?->getUrl())
                    ->openUrlInNewTab(),

                TextColumn::make('cover_status')
                    ->label('')
                    ->getStateUsing(function ($record) {
                        $hasPending = $record->pendingChanges()
                            ->where('status', 'pending')
                            ->exists();

                        return $hasPending ? 'تعديلات قيد الانتظار ⏳' : '';
                    })
                    ->color('warning')
                    ->size('sm'),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn($state) => VendorStatusEnum::from($state)->label())
                    ->colors(VendorStatusEnum::colors())
                    ->sortable(),

                TextColumn::make('id_card')
                    ->label('صورة الهوية')
                    ->getStateUsing(fn($record) => method_exists($record, 'getFirstMediaUrl') ? $record->getFirstMediaUrl('id_card') : null)
                    ->formatStateUsing(fn($state) => $state ? 'عرض الهوية' : '—')
                    ->url(fn($record) => method_exists($record, 'getFirstMediaUrl') ? $record->getFirstMediaUrl('id_card') : null)
                    ->openUrlInNewTab(),

                TextColumn::make('trade_license')
                    ->label('الرخصة التجارية')
                    ->getStateUsing(fn($record) => method_exists($record, 'getFirstMediaUrl') ? $record->getFirstMediaUrl('trade_license') : null)
                    ->formatStateUsing(fn($state) => $state ? 'عرض الرخصة' : '—')
                    ->url(fn($record) => method_exists($record, 'getFirstMediaUrl') ? $record->getFirstMediaUrl('trade_license') : null)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف جماعي'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PendingChangesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();
        return $user && $user->hasRole(RolesEnum::Admin);
    }
}
