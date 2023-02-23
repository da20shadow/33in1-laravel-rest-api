<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealLogs extends Model
{
    use HasFactory;
    protected $fillable = [
      'food_id',
      'meal_id',
      'serving_size', //The serving size of the food consumed in the meal.
      'quantity', //The number of servings of the food consumed in the meal.
      'user_id',
    ];
}
