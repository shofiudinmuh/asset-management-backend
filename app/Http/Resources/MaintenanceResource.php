<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\AssetResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceResource extends JsonResource
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
            'asset' => new AssetResource($this->whenLoaded('asset')),
            'maintenance_date' => $this->maintenance_date,
            'description' => $this->description,
            'cost' => $this->cost,
            'technician' => new UserResource($this->whenLoaded('technician')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}