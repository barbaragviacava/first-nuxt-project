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
            'name.filled' => __('You need to fill the name'),
            'email.filled' => __('You need to fill the e-mail'),
            'email.email' => __('The email sent is not valid'),
            'email.unique' => __('This email is already being used'),
        ];
    }
}
