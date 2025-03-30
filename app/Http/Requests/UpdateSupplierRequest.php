<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pastikan return true agar request bisa diproses
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'contact_person' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            // 'email' => 'sometimes|required|email|max:255|unique:suppliers,email,'.$this->supplier,
            'email' => 'sometimes|required|email|max:255',
            'address' => 'sometimes|required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama supplier wajib diisi',
            'name.string' => 'Nama supplier harus berupa teks',
            'name.max' => 'Nama supplier maksimal 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan oleh supplier lain',
            'phone.max' => 'Nomor telepon maksimal 20 karakter',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Jika diperlukan, bersihkan data sebelum validasi
        if ($this->has('phone')) {
            $this->merge([
                'phone' => preg_replace('/[^0-9]/', '', $this->phone),
            ]);
        }
    }
}