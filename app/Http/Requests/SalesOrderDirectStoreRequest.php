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
            'order_by_id' => ['required', 'exists:users,id'],
            'delivery_date' => ['required', 'date'],
            'delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'transfer_to_account_id' => [
                'required',
                'exists:transfer_to_accounts,id',
            ],
            'image_transfer' => ['image', 'nullable'],
            'payment_status' => ['required'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'submitted_by_id' => ['nullable', 'exists:users,id'],
            'received_by' => ['nullable', 'max:255', 'string'],
            'sign' => ['image', 'nullable'],
            'image_receipt' => ['image', 'nullable'],
            'delivery_status' => ['required'],
            'shipping_cost' => ['nullable'],
            'Discounts' => ['required', 'max:255'],
        ];
    }
}
