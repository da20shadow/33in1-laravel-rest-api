<?php

namespace App\Http\Requests\SleepLog;

use Illuminate\Foundation\Http\FormRequest;

class AddSleepLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sleep_start_time' => 'required|date',
            'sleep_end_time' => 'required|date|after:sleep_start_time',
            'nap_start_time' => 'nullable|date',
            'nap_end_time' => 'nullable|date|after:nap_start_time',
        ];
    }

    public function messages(): array
    {
        return [
            'sleep_start_time.required' => 'Sleep start hour is required!',
            'sleep_end_time.required' => 'Sleep end hour is required!',
            'sleep_end_time.after' => 'End sleep hour can not be before start sleep hour.',
            'nap_end_time.after' => 'End nap hour can not be before start nap hour.',
        ];
    }
}
