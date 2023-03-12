<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderEmployeeStoreRequest extends FormRequest
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
            'customer' => ['required', 'max:255', 'string'],
            'detail_customer' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'image'],
            'status' => ['nullable', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
