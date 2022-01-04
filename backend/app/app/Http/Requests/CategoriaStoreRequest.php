<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaStoreRequest extends FormRequest
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
        $conditionalRules = [];

        if ($this->categoria_pai_id > 0) {
            $conditionalRules['categoria_pai_id'] = 'exists:categorias,id';
        }

        return [
            'nome' => [
                'required',
                Rule::unique('categorias')->where(function ($query) {
                    return $query->where('id', '!=', $this->id)
                        ->where('active', true);
                })
            ],
        ] + $conditionalRules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required' => 'Você precisa preencher o nome',
            'nome.unique' => 'Já existe uma categoria ativa com esse nome',
            'categoria_pai_id.exists' => 'A categoria pai selecionada não existe mais',
        ];
    }
}
