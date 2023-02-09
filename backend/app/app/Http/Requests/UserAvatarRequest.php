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
            'avatar.required' => __('Unable to load the provided image'),
            'avatar.file' => __('The specified file is not valid'),
            'avatar.image' => __('The image provided is not valid.'),
        ];
    }
}
