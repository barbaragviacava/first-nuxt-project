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
            'name' => 'filled|max:255',
            'email' => [
                'filled',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::user()->id)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.filled' => __('You need to fill the :field', ['field' => 'name']),
            'name.max' => __(':field is longer than allowed', ['field' => 'Name']),
            'email.filled' => __('You need to fill the :field', ['field' => 'e-mail']),
            'email.email' => __('The :field sent is not valid', ['field' => 'e-mail']),
            'email.unique' => __('This :field is already being used', ['field' => 'e-mail']),
            'email.max' => __(':field is longer than allowed', ['field' => 'E-mail']),
        ];
    }
}
