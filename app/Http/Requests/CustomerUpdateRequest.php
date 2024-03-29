<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'no_telp' => [
                'nullable',
                Rule::unique('customers', 'no_telp')->ignore($this->customer),
                'max:255',
                'string',
            ],
            'status' => ['required', 'in:1,2'],
        ];
    }
}
