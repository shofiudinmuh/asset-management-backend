<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'category' => 'required|in:Kendaraan,Peralatan Elektronik,Perlengkapan Kantor,Furniture,IT Equipment',
            'serial_number' => 'required|string|unique:assets,serial_number',
            'purchase_date' => 'required|date',
            'warranty_expiry' => 'nullable|date',
            'status' => 'required|in:Tersedia,Dipinjam,Dalam Perbaikan,Rusak',
            'location_id' => 'required|exists:locations,id',
        ];
    }
}