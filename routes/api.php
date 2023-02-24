<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BodyCompositionController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\HomeworkLogController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MealLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaterController;
use App\Http\Controllers\WorkoutLogController;
use Illuminate\Support\Facades\Route;

/** ------------------------Public------------------------ */
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);


/** ----------------------Protected----------------------- */
Route::group(['middleware' => ['auth:sanctum']],function () {

    /** ----------USER---------- */
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::patch('profile/update', [UserController::class, 'update']);
    Route::delete('profile/delete', [UserController::class, 'destroy']);
    Route::get('body-composition', [BodyCompositionController::class, 'index']);
    Route::post('body-composition/add', [BodyCompositionController::class, 'store']);
    Route::patch('body-composition/update', [BodyCompositionController::class, 'update']);

    /** ----------Exercises---------- */
    Route::post('exercises/add',[ExerciseController::class,'store']);
    Route::patch('exercises/{id}/update',[ExerciseController::class,'update']);
    Route::delete('exercises/{id}/delete',[ExerciseController::class,'destroy']);
    Route::get('exercises/{id}/details',[ExerciseController::class,'show']);
    Route::get('exercises',[ExerciseController::class,'index']);

    /** ----------Workout Logs---------- */
    Route::post('workouts/add', [WorkoutLogController::class, 'store']);
    Route::patch('workouts/{id}', [WorkoutLogController::class, 'update']);
    Route::get('workouts/{id}', [WorkoutLogController::class, 'show']);
    Route::get('workouts', [WorkoutLogController::class, 'index']);

    /** ----------Homework---------- */
    Route::post('homework/add',[HomeWorkController::class,'store']);
    Route::patch('homework/{id}/update',[HomeWorkController::class,'update']);
    Route::delete('homework/{id}/delete',[HomeWorkController::class,'destroy']);
    Route::get('homework/{id}',[HomeWorkController::class,'show']);
    Route::get('homework',[HomeWorkController::class,'index']);

    /** ----------Homework Logs---------- */
    Route::post('homework-logs/add',[HomeworkLogController::class,'store']);
    Route::patch('homework-logs/{id}/update',[HomeworkLogController::class,'update']);
    Route::delete('homework-logs/{id}/delete',[HomeworkLogController::class,'destroy']);
    Route::get('homework-logs/{id}',[HomeworkLogController::class,'show']);
    Route::get('homework-logs',[HomeworkLogController::class,'index']);

    /** ----------Water---------- */
    Route::post('waters/add',[WaterController::class,'store']);
    Route::patch('waters/{id}/update',[WaterController::class,'update']);
    Route::delete('waters/{id}/delete',[WaterController::class,'destroy']);
    Route::get('waters/{id}',[WaterController::class,'show']);
    Route::get('waters',[WaterController::class,'index']);

    /** ----------Food---------- */
    Route::post('food/add',[FoodController::class,'store']);
    Route::patch('food/{id}/update',[FoodController::class,'update']);
    Route::delete('food/{id}/delete',[FoodController::class,'destroy']);
    Route::get('food/{id}',[FoodController::class,'show']);
    Route::get('food',[FoodController::class,'index']);

    /** ----------Meals---------- */
    Route::post('meals/add',[MealController::class,'store']);
    Route::patch('meals/{id}/update',[MealController::class,'update']);
    Route::delete('meals/{id}/delete',[MealController::class,'destroy']);
    Route::get('meals/{id}',[MealController::class,'show']);
    Route::get('meals',[MealController::class,'index']);

    /** ----------Meal Logs---------- */
    Route::post('meal-logs/add',[MealLogController::class,'store']);
    Route::patch('meal-logs/{id}/update',[MealLogController::class,'update']);
    Route::delete('meal-logs/{id}/delete',[MealLogController::class,'destroy']);
    Route::get('meal-logs/{id}',[MealLogController::class,'show']);
    Route::get('meal-logs',[MealLogController::class,'index']);

    /** ----------Activity---------- */
    Route::post('activities/add',[ActivityController::class,'store']);
    Route::patch('activities/{id}/update',[ActivityController::class,'update']);
    Route::delete('activities/{id}/delete',[ActivityController::class,'destroy']);
    Route::get('activities/{id}',[ActivityController::class,'show']);
    Route::get('activities',[ActivityController::class,'index']);

});
