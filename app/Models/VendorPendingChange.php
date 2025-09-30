<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPendingChange extends Model
{
    use HasFactory;

    protected $table = 'vendor_pending_changes';

    protected $fillable = [
        'vendor_id',
        'field',
        'old_value',
        'new_value',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // الانتماء إلى Vendor: foreignKey vendor_id يشير إلى owners.user_id
    public function vendor()
    {
        return $this->belongsTo(\App\Models\Vendor::class, 'vendor_id', 'user_id');
    }
}
