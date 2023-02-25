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
use App\Http\Controllers\SleepLogController;
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
    Route::patch('workouts/{id}/update', [WorkoutLogController::class, 'update']);
    Route::delete('workouts/{id}/delete', [WorkoutLogController::class, 'destroy']);
    Route::get('workouts/{id}/details', [WorkoutLogController::class, 'show']);
    Route::get('workouts', [WorkoutLogController::class, 'index']);

    /** ----------Homework---------- */
    Route::post('homework/add',[HomeWorkController::class,'store']);
    Route::patch('homework/{id}/update',[HomeWorkController::class,'update']);
    Route::delete('homework/{id}/delete',[HomeWorkController::class,'destroy']);
    Route::get('homework/{id}/details',[HomeWorkController::class,'show']);
    Route::get('homework',[HomeWorkController::class,'index']);

    /** ----------Homework Logs---------- */
    Route::post('homework-logs/add',[HomeworkLogController::class,'store']);
    Route::patch('homework-logs/{id}/update',[HomeworkLogController::class,'update']);
    Route::delete('homework-logs/{id}/delete',[HomeworkLogController::class,'destroy']);
    Route::get('homework-logs/{id}/details',[HomeworkLogController::class,'show']);
    Route::get('homework-logs',[HomeworkLogController::class,'index']);
    Route::get('homework-logs/details',[HomeworkLogController::class,'getHomeworkLogs']);

    /** ----------Water---------- */
    Route::post('waters/add',[WaterController::class,'store']);
    Route::patch('waters/{id}/update',[WaterController::class,'update']);
    Route::delete('waters/{id}/delete',[WaterController::class,'destroy']);
    Route::get('waters/{id}/details',[WaterController::class,'show']);
    Route::get('waters',[WaterController::class,'index']);

    /** ----------Food---------- */
    Route::post('foods/add',[FoodController::class,'store']);
    Route::patch('foods/{id}/update',[FoodController::class,'update']);
    Route::delete('foods/{id}/delete',[FoodController::class,'destroy']);
    Route::get('foods/{id}/details',[FoodController::class,'show']);
    Route::get('foods',[FoodController::class,'index']);

    /** ----------Meal Logs---------- */
    Route::post('meal-logs/add',[MealLogController::class,'store']);
    Route::patch('meal-logs/{id}/update',[MealLogController::class,'update']);
    Route::delete('meal-logs/{id}/delete',[MealLogController::class,'destroy']);
    Route::get('meal-logs/{id}/details',[MealLogController::class,'show']);
    Route::get('meal-logs',[MealLogController::class,'index']);

    /** ----------Sleep Logs---------- */
    Route::get('sleep-logs/clear', [SleepLogController::class, 'checkAndStopLastStartedSleepLogIfTooLong']);
    Route::post('sleep-logs/add', [SleepLogController::class, 'store']);
    Route::post('sleep-logs/start', [SleepLogController::class, 'startSleep']);
    Route::post('sleep-logs/stop', [SleepLogController::class, 'stopSleep']);
    Route::patch('sleep-logs/{id}/update', [SleepLogController::class, 'update']);
    Route::get('sleep-logs/{id}/details', [SleepLogController::class, 'show']);
    Route::delete('sleep-logs/{id}/delete', [SleepLogController::class, 'destroy']);
    Route::get('sleep-logs/', [SleepLogController::class, 'index']);

    /** ----------Activity---------- */
    //TODO: Status In progress
    Route::post('activities/add',[ActivityController::class,'store']);
    Route::patch('activities/{id}/update',[ActivityController::class,'update']);
    Route::delete('activities/{id}/delete',[ActivityController::class,'destroy']);
    Route::get('activities/{id}/details',[ActivityController::class,'show']);
    Route::get('activities',[ActivityController::class,'index']);

});
