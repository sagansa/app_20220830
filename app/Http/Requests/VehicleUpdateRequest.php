<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
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
            'no_register' => ['required', 'max:15', 'string'],
            'type' => ['required', 'in:1,2,3'],
            'store_id' => ['required', 'exists:stores,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:1,2'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
