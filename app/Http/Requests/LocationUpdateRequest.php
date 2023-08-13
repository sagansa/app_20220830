<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
            'store_id' => ['required', 'exists:stores,id'],
            'address' => ['required', 'max:255', 'string'],
            'contact_person_name' => ['required', 'max:255', 'string'],
            'contact_person_number' => ['required', 'max:255', 'string'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'codepos' => ['nullable', 'numeric'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
        ];
    }
}
