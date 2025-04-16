<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'variation_type_option_ids'
    ];

    protected $casts = [
        'variation_type_option_ids' => 'array'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variationOptions(): BelongsToMany
    {
        return $this->belongsToMany(VariationTypeOption::class, 'order_item_variation_type_option', 'order_item_id', 'variation_type_option_id');
    }
}
