<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
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

    public function messages(): array
    {
        return [
            'name.filled' => 'Você precisa preencher o nome',
            'email.filled' => 'Você precisa preencher o e-mail',
            'email.email' => 'O e-mail informado não é válido',
            'email.unique' => 'Este e-mail já está sendo utilizado por outro usuário',
        ];
    }
}
