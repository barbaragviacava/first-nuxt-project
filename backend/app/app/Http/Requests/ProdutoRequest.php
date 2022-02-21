<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'preco' => 'required|numeric|gt:0',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required' => 'Você precisa preencher o nome',
            'preco.required' => 'Você precisa preencher o preço',
            'preco.numeric' => 'O formato de preço informado é inválido',
            'preco.gt' => 'O preço precisa ser maior do que zero',
            'categoria_id.required' => 'Você precisa preencher a categoria',
            'categoria_id.exists' => 'A categoria selecionada não existe mais',
        ];
    }
}
