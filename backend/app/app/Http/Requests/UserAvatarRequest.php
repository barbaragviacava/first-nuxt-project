<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAvatarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar' => 'required|file|image',
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Não foi possível carregar a imagem informada',
            'avatar.file' => 'O arquivo informado não é válido',
            'avatar.image' => 'A imagem informada não é válida',
        ];
    }
}
