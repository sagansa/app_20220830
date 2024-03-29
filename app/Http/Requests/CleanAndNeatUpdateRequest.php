<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CleanAndNeatUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'left_hand' => ['image', 'nullable'],
            'right_hand' => ['image', 'nullable'],
            'status' => ['required', 'max:1'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
