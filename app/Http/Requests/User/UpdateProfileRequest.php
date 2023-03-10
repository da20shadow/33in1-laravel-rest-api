<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['min:2','max:45'],
            'last_name' => ['min:2','max:45'],
            'email' => ['email','regex:/^[a-z]+[a-z0-9_]{4,}[@][a-z]{2,15}[.][a-z]{2,7}$/i'],
            'password' => ['min:6','max:45','confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.min' => 'First name must be at least 2 characters long.',
            'first_name.max' => 'First name must be max 45 characters long',
            'last_name.min' => 'Last name must be at least 2 characters long',
            'last_name.max' => 'Last name must be max 45 characters long',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.regex' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.max' => 'The password must be max 45 characters.',
            'password.confirmed' => 'Password mismatch.',
        ];
    }
}
