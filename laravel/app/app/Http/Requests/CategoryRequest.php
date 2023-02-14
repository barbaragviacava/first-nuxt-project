<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $conditionalRules = [];

        if ($this->parent_category_id > 0) {
            $conditionalRules['parent_category_id'] = 'exists:categories,id';
        }

        return [
            'name' => [
                'required',
                'max:35',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('id', '!=', $this->id)
                        ->where('active', true);
                })
            ],
        ] + $conditionalRules;
    }

    public function messages(): array
    {
        return [
            'name.required' => __('You need to fill the :field', ['field' => 'name']),
            'name.max' => __(':field is longer than allowed', ['field' => 'Name']),
            'name.unique' => __('An active category with that name already exists'),
            'parent_category_id.exists' => __('The selected parent category no longer exists'),
        ];
    }
}
