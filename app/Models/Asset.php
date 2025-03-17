<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'category',
        'serial_number',
        'purchase_date',
        'warranty_expiry',
        'status',
        'location_id'
    ];
}