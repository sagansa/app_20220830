<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
                'unique:customers,no_telp',
                'max:255',
                'string',
            ],
            'status' => ['required', 'in:1,2'],
        ];
    }
}
