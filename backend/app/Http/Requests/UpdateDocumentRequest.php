<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'array'],
            'metadata' => ['nullable', 'array'],
            'status' => ['sometimes', 'in:draft,in_review,approved,published,archived'],
            'version' => ['sometimes', 'string', 'max:50'],
        ];
    }
}
