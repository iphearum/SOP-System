<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'version' => ['sometimes', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'sections_schema' => ['sometimes', 'array'],
            'required_metadata' => ['nullable', 'array'],
            'status' => ['sometimes', 'in:draft,active,archived'],
        ];
    }
}
