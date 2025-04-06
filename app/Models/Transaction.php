<?php

namespace App\Models;

use App\Models\User;
use App\Models\Asset;
use App\Models\Location;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'asset_id',
        'user_id',
        'transaction_type',
        'transaction_date',
        'location_id',
    ];


    protected $casts = [
        'transaction_date' => 'date',
    ];

    /**
     * Get the asset that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}