<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_id' => ['required', 'exists:templates,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'array'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
