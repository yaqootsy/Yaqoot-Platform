<?php

namespace App\Filament\Resources;

use App\Enums\RolesEnum;
use App\Enums\VendorStatusEnum;
use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Forms\Components\MapLocationPicker;

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
                        Forms\Components\TextInput::make('store_name')
                            ->label('اسم المتجر')
                            ->required(),

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
                                // هذا يضمن أن state الحقل يحتوي على القيم عند التعديل
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
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn($state) => VendorStatusEnum::from($state)->label())
                    ->colors(VendorStatusEnum::colors())
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف  جماعي'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
        $user = Filament::auth()->user();
        return $user && $user->hasRole(RolesEnum::Admin);
    }
}
