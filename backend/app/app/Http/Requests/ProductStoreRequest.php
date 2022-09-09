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
            'name.required' => 'Você precisa preencher o nome',
            'price.required' => 'Você precisa preencher o preço',
            'price.numeric' => 'O formato de preço informado é inválido',
            'price.gt' => 'O preço precisa ser maior do que zero',
            'category_id.required' => 'Você precisa preencher a categoria',
            'category_id.exists' => 'A categoria selecionada não existe mais',
        ];
    }
}
