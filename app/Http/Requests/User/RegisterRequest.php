<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['sometimes','string','min:2','max:45','nullable'],
            'email' => ['required','email','regex:/^[a-z]+[a-z0-9_]{4,}[@][a-z]{2,15}[.][a-z]{2,7}$/i'],
            'password' => ['required','min:6','max:45','confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.string' => 'Моля въведи валидно име.',
            'first_name.min' => 'Името трябва да бъде поне 2 символа.',
            'email.required' => 'Имейла е задължителен.',
            'email.email' => 'Моля въведи валиден имейл.',
            'email.regex' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.max' => 'The password must be max 45 characters.',
            'password.confirmed' => 'Password mismatch.',
        ];
    }
}
