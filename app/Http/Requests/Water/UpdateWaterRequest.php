<?php

namespace App\Http\Requests\Water;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWaterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['sometimes','numeric','between:50,10000'],
            'time' => ['sometimes','date'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.numeric' => 'Please enter valid amount of water!',
            'time.date' => 'Please enter valid time!',
        ];
    }
}
