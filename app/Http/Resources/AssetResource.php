<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'name' => $this->name,
            'category' => $this->category,
            'serial_number' => $this->serial_number,
            'purchase_date' => $this->purchase_date,
            'warranty_expiry' => $this->warranty_expiry,
            'status' => $this->status,
            'location' => new LocationResource($this->whenLoaded('location')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}