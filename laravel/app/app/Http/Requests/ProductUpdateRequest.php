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
            'name' => 'filled|max:100',
            'price' => 'filled|numeric|max:9999999|gt:0',
            'category_id' => 'filled|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.filled' => __('You need to fill the :field', ['field' => 'name']),
            'name.max' => __(':field is longer than allowed', ['field' => 'Name']),
            'price.filled' => __('You need to fill the :field', ['field' => 'price']),
            'price.numeric' => __('The :field format sent is invalid', ['field' => 'price']),
            'price.gt' => __(':field must be greater than zero', ['field' => 'Price']),
            'price.max' => __(':field is higher than allowed'),
            'category_id.filled' => __('You need to select a category'),
            'category_id.exists' => __('The selected parent category no longer exists'),
        ];
    }
}
