<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('You need to fill the name'),
            'price.required' => __('You need to fill the price'),
            'price.numeric' => __('The price format sent is invalid'),
            'price.gt' => __('Price must be greater than zero'),
            'category_id.required' => __('You need to select a category'),
            'category_id.exists' => __('The selected parent category no longer exists'),
        ];
    }
}
