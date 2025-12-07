<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Order extends Model
{
    protected $fillable = [
        'stripe_session_id',
        'payment_method',         // 'stripe' | 'cod' | ...
        'payment_status',         // 'pending' | 'paid' | 'failed' | ...
        'payment_reference',      // gateway transaction id / intent id
        'payment_details',        // json payload from gateway
        'paid_at',
        'cod_collected_at',
        'cod_collector_id',

        'user_id',
        'vendor_user_id',         // important — كنت تستخدمه عند الإنشاء
        'total_price',
        'status',
        'tracking_code',
        'tracking_code_added_at',
        'online_payment_commission',
        'website_commission',
        'vendor_subtotal',
        'payment_intent',
        'cancelled_by',
        'cancelled_at',
    ];
    
    protected $casts = [
        'tracking_code_added_at' => 'datetime',
        'paid_at' => 'datetime',
        'cod_collected_at' => 'datetime',
        'payment_details' => 'array',
        'cancelled_at' => 'datetime',
    ];

    public function scopeForVendor(Builder $query): Builder
    {
        return $query->where('vendor_user_id', auth()->id());
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vendorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_user_id');
    }

    /**
     * If you have a separate vendors table related to users
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_user_id', 'user_id');
    }

    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Who collected COD (optional)
     */
    public function codCollector(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'cod_collector_id');
    }
}
