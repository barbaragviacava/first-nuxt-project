<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioAvatarRequest extends FormRequest
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
            'avatar' => 'required|file|image',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'avatar.required' => 'Não foi possível carregar a imagem informada',
            'avatar.file' => 'O arquivo informado não é válido',
            'avatar.image' => 'A imagem informada não é válida',
        ];
    }
}
