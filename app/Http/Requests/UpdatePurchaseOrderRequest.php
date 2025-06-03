<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseOrderRequest extends FormRequest
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
            'supplier_id' => 'sometimes|exists:suppliers,id',
            'order_date' => 'sometimes|date',
            'total_soct' => 'sometimes|numeric',
            'status' => 'sometimes|in:Dipesan,Diterima,Dibatalkan',
        ];
    }
}