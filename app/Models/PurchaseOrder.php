<?php

namespace App\Models;

use App\Models\Supplier;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'supplier_id',
        'order_date',
        'total_cost',
        'status',
    ];

    protected $casts = [
        'order_date' => 'date',
        'total_cost' => 'decimal:2',
    ];

    /**
     * Get the supplier that owns the PurchaseOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}