<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'order_date' => $this->order_date,
            'total_soct' => $this->total_cost,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}