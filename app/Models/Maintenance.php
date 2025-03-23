<?php

namespace App\Models;

use App\Models\User;
use App\Models\Asset;
use Laravel\Sanctum\HasApiTokens;
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

    protected $casts = [
        'maintenance_date' => 'date',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the asset that owns the Maintenance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the technician that owns the Maintenance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}