<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'version' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'sections_schema' => ['required', 'array'],
            'required_metadata' => ['nullable', 'array'],
            'status' => ['required', 'in:draft,active,archived'],
        ];
    }
}
