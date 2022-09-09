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
            'name.required' => 'Você precisa preencher o nome',
            'name.unique' => 'Já existe uma categoria ativa com esse nome',
            'parent_category_id.exists' => 'A categoria pai selecionada não existe mais',
        ];
    }
}
