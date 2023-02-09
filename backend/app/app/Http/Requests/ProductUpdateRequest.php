<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'filled',
            'price' => 'filled|numeric|gt:0',
            'category_id' => 'filled|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.filled' => __('You need to fill the name'),
            'price.filled' => __('You need to fill the price'),
            'price.numeric' => __('The price format sent is invalid'),
            'price.gt' => __('Price must be greater than zero'),
            'category_id.filled' => __('You need to select a category'),
            'category_id.exists' => __('The selected parent category no longer exists'),
        ];
    }
}
