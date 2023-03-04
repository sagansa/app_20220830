<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermitEmployeeUpdateRequest extends FormRequest
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
            'reason' => ['required', 'max:255'],
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'max:255'],
            'created_by_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
