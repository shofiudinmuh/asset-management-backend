<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable =[
        'asset_id',
        'maintenance_date',
        'description',
        'cost',
        'technician_id',
    ];
}