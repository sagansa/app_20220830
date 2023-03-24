<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresenceUpdateRequest extends FormRequest
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
            'store_id' => ['required', 'exists:stores,id'],
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'latitude_in' => ['required', 'numeric'],
            'longitude_in' => ['required', 'numeric'],
            'image_in' => ['image', 'nullable'],
            'latitude_out' => ['nullable', 'numeric'],
            'longitude_out' => ['nullable', 'numeric'],
            'image_out' => ['image', 'nullable'],
            'status' => ['required', 'max:255'],
            'time_in' => ['required', 'date'],
            'time_out' => ['nullable', 'date'],
        ];
    }
}
