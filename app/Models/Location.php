<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\DatAssetsloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'address'
    ];

    /**
     * Get all of the assets for the Location
     *
     * @return HasMany
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Assets::class);
    }

    /**
     * Get all of the transactions for the Location
     *
     * @return \Illuminate\Database\Eloquent\Transactions\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}