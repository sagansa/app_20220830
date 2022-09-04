<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EProductUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'max:1024'],
            'product_id' => ['required', 'exists:products,id'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'quantity_stock' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
        ];
    }
}
