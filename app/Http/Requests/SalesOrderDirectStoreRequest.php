<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderDirectStoreRequest extends FormRequest
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
            'order_by_id' => ['nullable', 'exists:users,id'],
            'delivery_date' => ['required', 'date'],
            'delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'delivery_location_id' => [
                'nullable',
                'exists:delivery_locations,id',
            ],
            'transfer_to_account_id' => [
                'required',
                'exists:transfer_to_accounts,id',
            ],
            'payment_status' => ['required', 'max:255'],
            'image_transfer' => ['image', 'nullable'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'submitted_by_id' => ['nullable', 'exists:users,id'],
            'received_by' => ['nullable', 'max:255', 'string'],
            'delivery_status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'image_receipt' => ['image', 'nullable'],
            'sign' => ['image', 'nullable'],
            'shipping_cost' => ['nullable', 'numeric'],
            'discounts' => ['nullable', 'numeric'],
        ];
    }
}
