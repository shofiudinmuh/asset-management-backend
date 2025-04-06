<?php

namespace App\Models;

use App\Models\Asset;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetDocument extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'asset_id',
        'document_name',
        'file_path',
    ];

    /**
     * Get the asset that owns the AssetDocument
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}