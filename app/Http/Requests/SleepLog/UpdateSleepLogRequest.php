<?php

namespace App\Http\Requests\SleepLog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSleepLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sleep_start_time' => 'sometimes|date',
            'sleep_end_time' => 'sometimes|date',
            'nap_start_time' => 'sometimes|date',
            'nap_end_time' => 'sometimes|date',
        ];
    }

    public function messages(): array
    {
        return [
            'sleep_start_time.date' => 'Invalid time format! Please, enter valid hour and minutes!',
            'sleep_end_time.date' => 'Invalid time format! Please, enter valid hour and minutes!',
            'nap_start_time.date' => 'Invalid time format! Please, enter valid hour and minutes.',
            'nap_end_time.date' => 'Invalid time format! Please, enter valid hour and minutes.',
        ];
    }
}
