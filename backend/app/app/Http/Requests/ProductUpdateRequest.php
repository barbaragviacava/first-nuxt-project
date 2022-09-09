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
            'name.filled' => 'Você precisa preencher o nome',
            'price.filled' => 'Você precisa preencher o preço',
            'price.numeric' => 'O formato de preço informado é inválido',
            'price.gt' => 'O preço precisa ser maior do que zero',
            'category_id.filled' => 'Você precisa preencher a categoria',
            'category_id.exists' => 'A categoria selecionada não existe mais',
        ];
    }
}
