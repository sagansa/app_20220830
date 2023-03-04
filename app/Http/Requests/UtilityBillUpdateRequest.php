<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UtilityBillUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image'],
            'utility_id' => ['required', 'exists:utilities,id'],
            'date' => ['required', 'date'],
            'amount' => ['nullable', 'numeric', 'gt:0'],
            'initial_indicator' => ['nullable', 'numeric', 'gt:0'],
            'last_indicator' => ['required', 'numeric'],
        ];
    }
}
