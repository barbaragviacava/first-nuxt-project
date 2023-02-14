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
            'name' => 'required|max:100',
            'price' => 'required|numeric|max:9999999|gt:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('You need to fill the :field', ['field' => 'name']),
            'name.max' => __(':field is longer than allowed', ['field' => 'Name']),
            'price.required' => __('You need to fill the :field', ['field' => 'price']),
            'price.numeric' => __('The :field format sent is invalid', ['field' => 'price']),
            'price.gt' => __(':field must be greater than zero', ['field' => 'Price']),
            'price.max' => __(':field is higher than allowed'),
            'category_id.required' => __('You need to select a category'),
            'category_id.exists' => __('The selected parent category no longer exists'),
        ];
    }
}
