<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentReceiptStoreRequest extends FormRequest
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
            'image' => ['nullable', 'image'],
            'amount' => ['required', 'min:0', 'numeric'],
            'payment_for' => ['required', 'in:1,2,3'],
            'image_adjust' => ['image', 'nullable'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
