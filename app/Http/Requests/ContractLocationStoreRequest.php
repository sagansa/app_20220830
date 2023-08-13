<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractLocationStoreRequest extends FormRequest
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
            'location_id' => ['required', 'exists:locations,id'],
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'nominal_contract' => ['required', 'max:255'],
        ];
    }
}
