<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryLocationUpdateRequest extends FormRequest
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
            'label' => ['required', 'max:255', 'string'],
            'contact_name' => ['required', 'max:255', 'string'],
            'contact_number' => ['required', 'max:255', 'string'],
            'address' => ['required', 'max:255', 'string'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
        ];
    }
}
