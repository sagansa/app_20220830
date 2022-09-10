<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderEmployeeStoreRequest extends FormRequest
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
            'store_id' => ['required', 'exists:stores,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'delivery_address_id' => [
                'nullable',
                'exists:delivery_addresses,id',
            ],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'image'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
