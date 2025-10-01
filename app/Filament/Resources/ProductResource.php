<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatusEnum;
use App\Enums\RolesEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ProductImages;
use App\Filament\Resources\ProductResource\Pages\ProductVariations;
use App\Filament\Resources\ProductResource\Pages\ProductVariationTypes;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    protected static ?string $modelLabel = 'منتج';          // مفرد

    protected static ?string $pluralModelLabel = 'المنتجات'; // جمع

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->forVendor();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make([
                    'md' => 1,
                    'lg' => 2,
                ])
                    ->schema([
                        TextInput::make('title')
                            ->label('العنوان')
                            ->live(onBlur: true)
                            ->required()
                            ->afterStateUpdated(
                                function (string $operation, $state, callable $set) {
                                    $set("slug", slugArabic($state));
                                }
                            ),
                        TextInput::make('slug')
                            ->label('معرّف الصفحة')
                            ->required(),
                        Select::make('department_id')
                            ->relationship('department', 'name', function ($query) {
                                $query->where('active', true); // Filter departments with status active
                            })
                            ->label('القسم')
                            ->preload()
                            ->searchable()
                            ->required()
                            ->reactive() // Makes the field reactive to changes
                            ->afterStateUpdated(function (callable $set) {
                                $set('category_id', null); // Reset category when department changes
                            }),
                        Select::make('category_id')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query, callable $get) {
                                    $query->where('active', true);
                                    // Modify the category query based on the selected department
                                    $departmentId = $get('department_id'); // Get selected department ID
                                    if ($departmentId) {
                                        $query->where('department_id', $departmentId); // Filter categories based on department
                                    }
                                }
                            )
                            ->label('الفئة')
                            ->preload()
                            ->searchable()
                            ->required()
                    ])
                    ->columnSpan(2),
                Forms\Components\RichEditor::make('description')
                    ->label('الوصف')
                    ->required()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                        'table'
                    ])
                    ->columnSpan(2),
                TextInput::make('price')
                    ->label('السعر')
                    ->required()
                    ->numeric()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 1
                    ]),
                TextInput::make('quantity')
                    ->label('الكمية')
                    ->integer()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 1
                    ]),
                Select::make('status')
                    ->label('الحالة')
                    ->options(ProductStatusEnum::labels())
                    ->default(ProductStatusEnum::Draft->value)
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 1
                    ]),
                Forms\Components\Section::make('SEO')
                    ->heading('تهيئة محركات البحث (SEO)')
                    ->description('املأ الحقول التالية لتحسين ظهور المنتج في محركات البحث.')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('عنوان الميتا')
                            ->placeholder('مثال: هاتف iPhone 15 في درعا – أفضل سعر')
                            ->helperText('يظهر هذا العنوان في نتائج البحث ويجب أن يحتوي على اسم المنتج والموقع.')
                            ->required(),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('وصف الميتا')
                            ->rows(3)
                            ->placeholder('مثال: اكتشف أحدث هاتف iPhone 15 في درعا مع أفضل العروض وأسعار منافسة وخدمة توصيل سريعة.')
                            ->helperText('الوصف يظهر أسفل العنوان في نتائج البحث ويجب أن يصف المنتج والموقع بشكل مشوق.')
                            ->required(),
                    ])
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->limit(1)
                    ->label('صورة المنتج')
                    ->conversion('thumb'),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->sortable()
                    ->words(7)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors(ProductStatusEnum::colors()),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('القسم'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('الفئة'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تم إنشاؤه في')
                    ->dateTime()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(ProductStatusEnum::labels()),
                SelectFilter::make('department_id')
                    ->label('القسم')
                    ->relationship('department', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'images' => Pages\ProductImages::route('/{record}/images'),
            'variation-types' => Pages\ProductVariationTypes::route('/{record}/variation-types'),
            'variations' => Pages\ProductVariations::route('/{record}/variations'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditProduct::class,
            ProductImages::class,
            ProductVariationTypes::class,
            ProductVariations::class
        ]);
    }

    public static function canViewAny(): bool
    {
        $user = Filament::auth()->user();

        return $user && $user->hasRole(RolesEnum::Vendor);
    }
}
