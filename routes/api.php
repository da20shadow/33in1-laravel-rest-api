<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BodyCompositionController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\HomeworkLogController;
use App\Http\Controllers\MealLogController;
use App\Http\Controllers\SleepLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaterController;
use App\Http\Controllers\WorkoutLogController;
use Illuminate\Support\Facades\Route;

/** ------------------------Public------------------------ */
Route::post('auth/login',[AuthController::class,'login']);
Route::post('auth/register',[AuthController::class,'register']);


/** ----------------------Protected----------------------- */
Route::group(['middleware' => ['auth:sanctum']],function () {

    /** ----------USER---------- */
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('users/profile', [UserController::class, 'profile']);
    Route::patch('users/profile/update', [UserController::class, 'update']);
    Route::delete('users/profile/delete', [UserController::class, 'destroy']);
    Route::get('body-composition', [BodyCompositionController::class, 'index']);
    Route::post('body-composition/add', [BodyCompositionController::class, 'store']);
    Route::patch('body-composition/update', [BodyCompositionController::class, 'update']);

    /** ----------Exercises---------- */
    Route::post('exercises/add',[ExerciseController::class,'store']);
    Route::patch('exercises/update/{id}',[ExerciseController::class,'update']);
    Route::delete('exercises/delete/{id}',[ExerciseController::class,'destroy']);
    Route::get('exercises/details/{id}',[ExerciseController::class,'show']);
    Route::get('exercises',[ExerciseController::class,'index']);

    /** ----------Workout Logs---------- */
    Route::post('workouts/add', [WorkoutLogController::class, 'store']);
    Route::patch('workouts/update/{id}', [WorkoutLogController::class, 'update']);
    Route::delete('workouts/delete/{id}', [WorkoutLogController::class, 'destroy']);
    Route::get('workouts/details/{id}', [WorkoutLogController::class, 'show']);
    Route::get('workouts', [WorkoutLogController::class, 'index']);

    /** ----------Homework---------- */
    Route::post('homework/add',[HomeWorkController::class,'store']);
    Route::patch('homework/update/{id}',[HomeWorkController::class,'update']);
    Route::delete('homework/delete/{id}',[HomeWorkController::class,'destroy']);
    Route::get('homework/details/{id}',[HomeWorkController::class,'show']);
    Route::get('homework',[HomeWorkController::class,'index']);

    /** ----------Homework Logs---------- */
    Route::post('homework-logs/add',[HomeworkLogController::class,'store']);
    Route::patch('homework-logs/update/{id}',[HomeworkLogController::class,'update']);
    Route::delete('homework-logs/delete/{id}',[HomeworkLogController::class,'destroy']);
    Route::get('homework-logs/details/{id}',[HomeworkLogController::class,'show']);
    Route::get('homework-logs',[HomeworkLogController::class,'index']);
    Route::get('homework-logs/details',[HomeworkLogController::class,'getHomeworkLogs']);

    /** ----------Water---------- */
    Route::post('waters/add',[WaterController::class,'store']);
    Route::patch('waters/update/{id}',[WaterController::class,'update']);
    Route::delete('waters/delete/{id}',[WaterController::class,'destroy']);
    Route::get('waters/details/{id}',[WaterController::class,'show']);
    Route::get('waters',[WaterController::class,'index']);

    /** ----------Food---------- */
    Route::post('foods/add',[FoodController::class,'store']);
    Route::patch('foods/update/{id}',[FoodController::class,'update']);
    Route::delete('foods/delete/{id}',[FoodController::class,'destroy']);
    Route::get('foods/details/{id}',[FoodController::class,'show']);
    Route::get('foods',[FoodController::class,'index']);

    /** ----------Meal Logs---------- */
    Route::post('meal-logs/add',[MealLogController::class,'store']);
    Route::patch('meal-logs/update/{id}',[MealLogController::class,'update']);
    Route::delete('meal-logs/delete/{id}',[MealLogController::class,'destroy']);
    Route::get('meal-logs/details/{id}',[MealLogController::class,'show']);
    Route::get('meal-logs',[MealLogController::class,'index']);

    /** ----------Sleep Logs---------- */
    Route::get('sleep-logs/clear', [SleepLogController::class, 'checkAndStopLastStartedSleepLogIfTooLong']);
    Route::post('sleep-logs/add', [SleepLogController::class, 'store']);
    Route::post('sleep-logs/start', [SleepLogController::class, 'startSleep']);
    Route::post('sleep-logs/stop', [SleepLogController::class, 'stopSleep']);
    Route::patch('sleep-logs/update/{id}', [SleepLogController::class, 'update']);
    Route::delete('sleep-logs/delete/{id}', [SleepLogController::class, 'destroy']);
    Route::get('sleep-logs/details/{id}', [SleepLogController::class, 'show']);
    Route::get('sleep-logs/', [SleepLogController::class, 'index']);

    /** ----------Activity---------- */
    //TODO: Status In progress
    Route::post('activities/add',[ActivityController::class,'store']);
    Route::patch('activities/update/{id}',[ActivityController::class,'update']);
    Route::delete('activities/delete/{id}',[ActivityController::class,'destroy']);
    Route::get('activities/details/{id}',[ActivityController::class,'show']);
    Route::get('activities',[ActivityController::class,'index']);

});
