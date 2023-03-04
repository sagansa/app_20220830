<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovementAssetResultUpdateRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
