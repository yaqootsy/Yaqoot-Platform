<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Card;
use Filament\Infolists\Components\Group;
use Illuminate\Support\Number;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Order Number')
                                    ->size('lg')
                                    ->weight('bold'),
                                TextEntry::make('created_at')
                                    ->label('Date')
                                    ->dateTime(),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match($state) {
                                        OrderStatusEnum::Paid->value => 'primary',
                                        OrderStatusEnum::Shipped->value => 'warning',
                                        OrderStatusEnum::Delivered->value => 'success',
                                        OrderStatusEnum::Cancelled->value => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('total_price')
                                    ->label('Total Price')
                                    ->formatStateUsing(fn ($state) => Number::currency($state, config('app.currency')))
                                    ->size('lg')
                                    ->weight('bold'),
                                TextEntry::make('vendor_subtotal')
                                    ->label('Vendor Subtotal')
                                    ->formatStateUsing(fn ($state) => Number::currency($state, config('app.currency'))),
                                TextEntry::make('online_payment_commission')
                                    ->label('Payment Commission')
                                    ->formatStateUsing(fn ($state) => Number::currency($state, config('app.currency'))),
                                TextEntry::make('website_commission')
                                    ->label('Website Commission')
                                    ->formatStateUsing(fn ($state) => Number::currency($state, config('app.currency'))),
                            ]),
                    ]),

                Grid::make(2)
                    ->schema([
                        Card::make()
                            ->schema([
                                Section::make('Customer Information')
                                    ->schema([
                                        TextEntry::make('user.name')
                                            ->label('Customer Name')
                                            ->icon('heroicon-o-user'),
                                        TextEntry::make('user.email')
                                            ->label('Customer Email')
                                            ->icon('heroicon-o-envelope'),
                                    ])
                                    ->columns(1),
                            ])
                            ->columnSpan(1),

                        Card::make()
                            ->schema([
                                Section::make('Shipping Address')
                                    ->schema([
                                        TextEntry::make('shippingAddress.full_name')
                                            ->label('Full Name'),
                                        TextEntry::make('shippingAddress.phone')
                                            ->label('Phone')
                                            ->icon('heroicon-o-phone'),
                                        TextEntry::make('shippingAddress.address1')
                                            ->label('Address Line 1'),
                                        TextEntry::make('shippingAddress.address2')
                                            ->label('Address Line 2')
                                            ->visible(fn ($record) => !empty($record->shippingAddress?->address2)),
                                        Grid::make(3)
                                            ->schema([
                                                TextEntry::make('shippingAddress.city')
                                                    ->label('City'),
                                                TextEntry::make('shippingAddress.state')
                                                    ->label('State/Province'),
                                                TextEntry::make('shippingAddress.zipcode')
                                                    ->label('Zip/Postal Code'),
                                            ]),
                                        TextEntry::make('shippingAddress.country.name')
                                            ->label('Country'),
                                        TextEntry::make('shippingAddress.delivery_instructions')
                                            ->label('Delivery Instructions')
                                            ->visible(fn ($record) => !empty($record->shippingAddress?->delivery_instructions)),
                                    ])
                                    ->columns(1),
                            ])
                            ->columnSpan(1),
                    ]),

                Section::make('Order Items')
                    ->schema([
                        Card::make()
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        TextEntry::make('subtotal')
                                            ->label('Subtotal')
                                            ->state(function ($record) {
                                                $subtotal = 0;
                                                foreach ($record->orderItems as $item) {
                                                    $subtotal += $item->price * $item->quantity;
                                                }
                                                return $subtotal;
                                            })
                                            ->formatStateUsing(fn ($state) => Number::currency($state, config('app.currency')))
                                            ->alignEnd(),

                                        TextEntry::make('total')
                                            ->label('Total')
                                            ->state(function ($record) {
                                                return $record->total_price;
                                            })
                                            ->formatStateUsing(fn ($state) => Number::currency($state, config('app.currency')))
                                            ->weight('bold')
                                            ->size('lg')
                                            ->alignEnd(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),

                        RepeatableEntry::make('orderItems')
                            ->schema([
                                Card::make()
                                    ->schema([
                                        Grid::make()
                                            ->schema([
                                                ImageEntry::make('product_image')
                                                    ->label('Product')
                                                    ->getStateUsing(function ($record) {
                                                        if ($record->product) {
                                                            if (!empty($record->variation_type_option_ids)) {
                                                                return $record->product->getImageForOptions($record->variation_type_option_ids);
                                                            }
                                                            return $record->product->getFirstImageUrl();
                                                        }
                                                        return null;
                                                    })
                                                    ->defaultImageUrl(asset('images/placeholder-product.jpg'))
                                                    ->height(80)
                                                    ->width(80)
                                                    ->columnSpan(1),

                                                Group::make([
                                                    TextEntry::make('product.title')
                                                        ->label('Product Name')
                                                        ->placeholder('Product')
                                                        ->weight('bold')
                                                        ->size('lg'),
                                                    TextEntry::make('product.user.vendor.store_name')
                                                        ->label('Vendor')
                                                        ->visible(fn ($record) => $record->product?->user?->vendor),
                                                    TextEntry::make('variationDetails')
                                                        ->label('Variations')
                                                        ->getStateUsing(function ($record) {
                                                            if (empty($record->variation_type_option_ids)) {
                                                                return null;
                                                            }

                                                            $variations = [];
                                                            foreach ($record->variationOptions as $option) {
                                                                $variations[] = "{$option->variation_type->name}: {$option->name}";
                                                            }

                                                            return !empty($variations) ? implode(', ', $variations) : null;
                                                        })
                                                        ->visible(fn ($record) => !empty($record->variation_type_option_ids)),
                                                ])
                                                ->columnSpan(2),

                                                Group::make([
                                                    TextEntry::make('price')
                                                        ->label('Unit Price')
                                                        ->formatStateUsing(fn ($state) => Number::currency($state, config('app.currency')))
                                                        ->alignEnd(),
                                                    TextEntry::make('quantity')
                                                        ->label('Quantity')
                                                        ->alignEnd(),
                                                    TextEntry::make('itemTotal')
                                                        ->label('Total')
                                                        ->formatStateUsing(fn ($record) => Number::currency($record->price * $record->quantity, config('app.currency')))
                                                        ->getStateUsing(fn ($record) => $record->price * $record->quantity)
                                                        ->weight('bold')
                                                        ->alignEnd(),
                                                ])
                                                ->columnSpan(1),
                                            ])
                                            ->columns(4),
                                    ])
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('print_invoice')
                ->label('Print Invoice')
                ->icon('heroicon-o-printer')
                ->url(fn (Order $record) => route('filament.admin.resources.orders.invoice', $record))
                ->openUrlInNewTab(),
        ];
    }
}
