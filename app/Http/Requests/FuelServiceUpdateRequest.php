<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelServiceUpdateRequest extends FormRequest
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
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'fuel_service' => ['required', 'in:1,2'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'km' => ['required', 'gt:0', 'numeric'],
            'liter' => ['required', 'gt:0', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
