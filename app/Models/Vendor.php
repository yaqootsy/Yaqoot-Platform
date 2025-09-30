<?php

namespace App\Models;

use App\Enums\VendorStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;



class Vendor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $primaryKey = 'user_id';

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100);

        $this->addMediaConversion('small')
            ->width(480);

        $this->addMediaConversion('large')
            ->width(1200);
    }

    public function scopeEligibleForPayout(Builder $query): Builder
    {
        return $query
            ->where('status', VendorStatusEnum::Approved)
            ->join('users', 'users.id', '=', 'vendors.user_id')
            ->where('users.stripe_account_active', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pendingChanges()
    {
        // hasMany(VendorPendingChange, foreignKey on pending table, localKey on vendors table)
        return $this->hasMany(\App\Models\VendorPendingChange::class, 'vendor_id', 'user_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_images')->singleFile();
        $this->addMediaCollection('id_card')->singleFile();
        $this->addMediaCollection('trade_license')->singleFile();
    }
}
