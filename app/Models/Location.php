<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'address'
    ];
}