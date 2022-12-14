<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentReceiptUpdateRequest extends FormRequest
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
            'amount' => ['required', 'min:0', 'numeric'],
            'payment_for' => ['required', 'in:1,2,3'],
            'image_adjust' => ['image', 'nullable'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
