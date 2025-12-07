<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\RolesEnum;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use NumberFormatter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $modelLabel = 'طلب';          // مفرد
    protected static ?string $pluralModelLabel = 'الطلبات'; // جمع


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->forVendor();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options(OrderStatusEnum::labels())
                    ->required(),
                Forms\Components\TextInput::make('tracking_code')
                    ->label('رمز التتبع')
                    ->placeholder('أدخل رمز تتبع الشحنة')
                    ->helperText('قدم رمز التتبع من شركة الشحن. سيتلقى العميل إشعارًا عبر البريد الإلكتروني.')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('رقم الطلب')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('العميل')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('الإجمالي')
                    ->formatStateUsing(function ($state) {
                        return Number::currency($state, config('app.currency'));
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('vendor_subtotal')
                    ->label('المجموع الفرعي للبائع')
                    ->formatStateUsing(function ($state) {
                        return Number::currency($state, config('app.currency'));
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('حالة الطلب')
                    ->badge()
                    ->colors(OrderStatusEnum::colors())
                    ->sortable()
                    ->formatStateUsing(fn(string $state) => OrderStatusEnum::labels()[$state] ?? $state),


                Tables\Columns\TextColumn::make('payment_method')
                    ->label('طريقة الدفع')
                    ->badge()
                    ->colors(PaymentMethodEnum::colors())
                    ->sortable()
                    ->formatStateUsing(fn(string $state) => PaymentMethodEnum::labels()[$state] ?? $state),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('حالة الدفع')
                    ->badge()
                    ->colors(PaymentStatusEnum::colors())
                    ->sortable()
                    ->formatStateUsing(fn(string $state) => PaymentStatusEnum::labels()[$state] ?? $state),
                Tables\Columns\TextColumn::make('tracking_code')
                    ->label('رمز التتبع')
                    ->searchable()
                    ->placeholder('—')
                    ->copyable()
                    ->icon('heroicon-o-truck'),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الطلب')
                    ->options(OrderStatusEnum::labels()),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('حالة الدفع')
                    ->options(PaymentStatusEnum::labels())
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->disabled(fn($record) => $record->status === OrderStatusEnum::Cancelled->value)
                    ->tooltip(fn($record) => $record->status === OrderStatusEnum::Cancelled->value
                        ? 'لا يمكن تعديل الطلب الملغى'
                        : null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Filament::auth()->user();

        // Example: Show this menu item only to users with the 'admin' role
        return $user && $user->hasRole(RolesEnum::Vendor);
    }
}
