<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsuarioUpdateRequest extends FormRequest
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
            'name' => 'filled',
            'email' => [
                'filled',
                'email',
                Rule::unique('users')->ignore(Auth::user()->id)
            ]
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.filled' => 'Você precisa preencher o nome',
            'email.filled' => 'Você precisa preencher o e-mail',
            'email.email' => 'O e-mail informado não é válido',
            'email.unique' => 'Este e-mail já está sendo utilizado por outro usuário',
        ];
    }
}
