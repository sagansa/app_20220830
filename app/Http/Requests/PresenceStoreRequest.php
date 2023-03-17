<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresenceStoreRequest extends FormRequest
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
            'time_in' => ['required', 'date_format:H:i:s'],
            'time_out' => ['nullable', 'date_format:H:i:s'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'latitude_in' => ['required', 'numeric'],
            'longitude_in' => ['required', 'numeric'],
            'image_in' => ['image', 'max:1024', 'nullable'],
            'latitude_out' => ['nullable', 'numeric'],
            'longitude_out' => ['nullable', 'numeric'],
            'image_out' => ['image', 'max:1024', 'nullable'],
            'status' => ['required', 'max:255'],
        ];
    }
}
