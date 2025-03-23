<?php

namespace App\Models;

use App\Models\PurchaseOrder;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address'
    ];

    /**
     * Get all of the purchaseOrders for the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}