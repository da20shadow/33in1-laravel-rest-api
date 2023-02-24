<?php

namespace App\Http\Requests\Water;

use Illuminate\Foundation\Http\FormRequest;

class AddWaterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required','numeric','between:50,10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.numeric' => 'Please enter valid amount of water!',
            'amount.required' => 'Please enter water amount!',
        ];
    }
}
