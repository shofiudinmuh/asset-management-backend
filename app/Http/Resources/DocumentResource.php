<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'asset_id' => $this->asset_id,
            'document_name' => $this->document_name,
            'file_path' => asset('storage/document' . $this->file_path),
            'created_at' => $this->created_at,
            'updated_at' =>$this->updated_at
        ];
    }
}