<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelServiceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['nullable', 'image'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'fuel_service' => ['required', 'in:1,2'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'km' => ['required', 'gt:0', 'string'],
            'liter' => ['required', 'gt:0', 'string'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'closing_store_id' => ['required', 'exists:closing_stores,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
