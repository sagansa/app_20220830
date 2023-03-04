<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
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
            'e_product_id' => ['required', 'exists:e_products,id'],
            'quantity' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
