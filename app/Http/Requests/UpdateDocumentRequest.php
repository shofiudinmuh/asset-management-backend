<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
            'asset_id' => 'sometimes|exists:assets,id',
            'document_name' => 'sometimes|string|max:255',
            'file' => 'sometimes|file|mimes:pdf,jpg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'document_name.string' => 'Nama dokumen harus berupa teks.',
            'document_name.max' => 'Nama dokumen tidak boleh lebih dari 255 karakter.',
            'file.mimes' => 'File harus berupa PDF, JPG, atau PNG.',
            'file.max' => 'File tidak boleh dari 2MB.',
        ];
    }
}