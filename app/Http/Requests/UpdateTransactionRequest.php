<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
            'user_id' => 'sometimes|exists:users,id',
            'transaction_type' => 'required|in:Pinjam,Kembalikan,Transfer',
            'transaction_date' => 'required|date',
            'location_id' => 'required|exists:locations,id',
        ];
    }
}