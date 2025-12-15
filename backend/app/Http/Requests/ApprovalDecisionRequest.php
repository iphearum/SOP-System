<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalDecisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'decision' => ['required', 'in:approved,rejected'],
            'comment' => ['nullable', 'string'],
            'step' => ['required', 'integer', 'min:1'],
        ];
    }
}
