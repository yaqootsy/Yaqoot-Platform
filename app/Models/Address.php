<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
class Address extends Model
{
    protected $fillable = [
        'user_id',
        'addressable_id', // Add this
        'addressable_type', // Add this
        'country_code',
        'latitude',
        'longitude',
        'full_name',
        'phone',
        'city',
        'type',
        'zipcode',
        'address1',
        'address2',
        'state',
        'default',
        'delivery_instructions',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function belongs(User $user): bool
    {
        return $this->addressable_type === User::class && $this->addressable_id === $user->id;
    }
    
    // Optional: for handling null values for latitude/longitude
    protected function latitude(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value === '' ? null : $value,
        );
    }
    protected function longitude(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value === '' ? null : $value,
        );
    }
}