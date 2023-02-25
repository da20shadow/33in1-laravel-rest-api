<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes','string','min:2','max:255'],
            'calories' => ['sometimes','numeric','between:1,10000'],
            'carbs' => ['sometimes','numeric','between:0,10000'],
            'protein' => ['sometimes','numeric','between:0,10000'],
            'fat' => ['sometimes','numeric','between:0,10000'],
            'category' => ['sometimes','string',Rule::in(['Appetizer','Fruits salad','Vegetable salad','Soup','Fish','Main dish','Roast','Dessert','Snack'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Please enter valid amount of water!',
            'name.required' => 'Please enter water amount!',
            'calories.numeric' => 'Please enter valid amount of calories!',
            'carbs.numeric' => 'Please enter valid amount of carbs!',
            'protein.numeric' => 'Please enter valid amount of protein!',
            'fat.numeric' => 'Please enter valid amount of fats!',
            'category.string' => 'Please enter valid food category!',
        ];
    }
}
