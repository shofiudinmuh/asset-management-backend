<?php

namespace App\Models;

use App\Models\Location;
use App\Models\Maintenance;
use App\Models\Transaction;
use App\Models\AssetDocument;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
    ];
    
    /**
     * Get the location that owns the Asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get all of the maintenances for the Asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Get all of the transactions for the Asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get all of the assetDocuments for the Asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetDocuments(): HasMany
    {
        return $this->hasMany(AssetDocument::class);
    }
}