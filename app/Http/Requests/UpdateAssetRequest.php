<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:Mesin,Kendaraan,Peralatan,Bahan Baku',
            'serial_number' => 'sometimes|string|unique:assets,serial_number,'.$this->asset->id,
            'purchase_date' => 'sometimes|date',
            'warranty_expiry' => 'nullable|date',
            'status' => 'sometimes|in:Tersedia,Dipinjam,Dalam Perbaikan,Rusak',
            'location_id' => 'sometimes|exists:locations,id',
        ];
    }
}