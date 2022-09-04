<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoicePurchaseUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'date' => ['required', 'date'],
            'discounts' => ['required', 'numeric', 'min:0'],
            'taxes' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:1,2,3,4'],
            'order_status' => ['required', 'in:1,2,3'],
            'notes' => ['required', 'max:255', 'string'],
        ];
    }
}
