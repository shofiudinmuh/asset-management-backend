<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'asset_id' => 'required|exists:assets,id',
            'user_id' => 'required|exists:users,id',
            'transaction_type' => 'required|in:Pinjam,Kembalikan,Transfer',
            'transaction_date' => 'required|date',
            'location_id' => 'required|exists:locations,id',
        ];
    }
}