<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferToAccountUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'number' => ['required', 'max:255'],
            'bank_id' => ['required', 'exists:banks,id'],
            'status' => ['required', 'max:255'],
        ];
    }
}
