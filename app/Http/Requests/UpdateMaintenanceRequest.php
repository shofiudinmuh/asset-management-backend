<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'asset_id' => 'sometimes|exists:assets,id',
            'maintenance_date' => 'sometimes|date',
            'description' => 'sometimes|string',
            'cost' => 'sometimes|numeric',
            'technician_id' => 'sometimes|exists:users,id',
        ];
    }
}