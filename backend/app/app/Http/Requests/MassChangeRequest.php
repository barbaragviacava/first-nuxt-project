<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassChangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'ids.required' => 'Informe os ids que serão afetados',
        ];
    }
}
