<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EProductStoreRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'quantity_stock' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2'],
        ];
    }
}
