<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,png,png|max:2048',
        ];
    }

    public function message()
    {
        return [
            'asset_id.required' => 'Asset ID wajib diisi.',
            'document_name.required' => 'Nama dokumen wajib diisi.',
            'file.required' => 'File wajib diupload.',
            'file.mimes' => 'File harus berupa PDF, JPG, atau PNG.',
            'file.max' => 'File tidak boleh lebih dari 2MB.',
        ];
    }
}