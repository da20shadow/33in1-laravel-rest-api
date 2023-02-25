<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Http\Requests\MealLog\AddMealLogRequest;
use App\Http\Requests\MealLog\UpdateMealLogRequest;
use App\Models\MealLogs;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MealLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $days = $request->input('days', '30'); // Get days
        if ($days && $days < 1) {
            $days = 1;
        } else if ($days && $days > 30) {
            $days = 30;
        }

        $userId = auth()->user()->getAuthIdentifier();
        try {

            $mealLogs = DB::table('meal_logs')
                ->join('food', 'meal_logs.food_id', '=', 'food.id')
                ->select('meal_logs.*', 'food.*')
                ->where('meal_logs.user_id', $userId)
                ->whereBetween('created_at', [
                    now()->subDays($days)->format('Y-m-d H:i:s'),
                    now()->addDay()->format('Y-m-d H:i:s')])
                ->orderBy('meal_logs.created_at', 'desc')
                ->get();

            $formattedLogs = [];
            foreach ($mealLogs as $log) {
                $date = Carbon::parse($log->created_at)->format('Y-m-d');
                $time = Carbon::parse($log->created_at)->format('H:i');
                $servingSize = $log->serving_size;
                $quantity = $log->quantity;
                $calories = round(($log->calories * $servingSize * $quantity) / 100, 1);
                $carbs = round(($log->carbs * $servingSize * $quantity) / 100, 1);
                $protein = round(($log->protein * $servingSize * $quantity) / 100, 1);
                $fat = round(($log->fat * $servingSize * $quantity) / 100, 1);
                $mealType = $log->meal_type;
                $foodName = $log->name;
                $foodCategory = $log->category;

                if (!isset($formattedLogs[$date])) {
                    $formattedLogs[$date] = [
                        'total_calories' => 0,
                        'total_carbs' => 0,
                        'total_protein' => 0,
                        'total_fat' => 0,
                        'meals' => [],
                    ];
                }

                $formattedLogs[$date]['total_calories'] += $calories;
                $formattedLogs[$date]['total_carbs'] += $carbs;
                $formattedLogs[$date]['total_protein'] += $protein;
                $formattedLogs[$date]['total_fat'] += $fat;

                $formattedLogs[$date]['meals'][] = [
                    'time' => $time,
                    'meal_type' => $mealType,
                    'food_name' => $foodName,
                    'serving_size' => $servingSize,
                    'quantity' => $quantity,
                    'calories' => $calories,
                    'carbs' => $carbs,
                    'protein' => $protein,
                    'fat' => $fat,
                    'category' => $foodCategory,
                ];
            }

            return response()->json($formattedLogs);

        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }

    }

    public function store(AddMealLogRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            //Check if food id exist
            if (!FoodController::foodExistById($validatedData['food_id'])) {
                return response()->json([
                    'message' => Messages::FOOD_NOT_FOUND,
                ], 400);
            }

            //TODO: make the timezone dynamic or get the Country from user
            $timezone = new DateTimeZone('Europe/Sofia');
            $datetime = new DateTime('now', $timezone);
            $current_datetime = $datetime->format('Y-m-d H:i:s');
            $validatedData['created_at'] = $current_datetime;

            $mealType = $this->validateMealType($validatedData['meal_type'], 'Europe/Sofia');

            if (!$mealType) {
                return response()->json(['message' => Messages::ADD_FOOD_FAILURE,'error' => 'Invalid meal type!'], 400);
            }
            $validatedData['meal_type'] = $mealType;

            $validatedData['user_id'] = auth()->user()->getAuthIdentifier();

            $result = DB::table('meal_logs')->insert([$validatedData]);
            if ($result) {
                return response()->json(['message' => Messages::ADD_FOOD_SUCCESS], 201);
            }
            return response()->json(['message' => Messages::ADD_FOOD_FAILURE], 400);

        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $exercise = DB::table('meal_logs')
                ->where(['id' => $id, 'user_id' => $userId])
                ->first();
            if ($exercise) {
                return response()->json($exercise);
            }
            return response()->json([
                'message' => Messages::FOOD_NOT_FOUND,
            ], 400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(UpdateMealLogRequest $request, string $id): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $validatedData = $request->validated();
            //Check if food and exist
            if (isset($validatedData['food_id']) && !FoodController::foodExistById($validatedData['food_id'])) {
                return response()->json([
                    'message' => Messages::FOOD_NOT_FOUND,
                ], 400);
            }

            //Check if the requested meal is for the current user
            if (!$this->existMealLogByIdAndUserId($id, $userId)) {
                return response()->json([
                    'message' => Messages::MEAL_LOG_NOT_FOUND,
                ], 400);
            }

            $result = DB::table('meal_logs')
                ->where(['id' => $id, 'user_id' => $userId])
                ->update($validatedData);
            if ($result) {
                return response()->json(['message' => Messages::UPDATE_MEAL_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::UPDATE_MEAL_LOG_FAILURE], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $result = MealLogs::where(['id' => $id, 'user_id' => $userId])->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETE_MEAL_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETE_MEAL_LOG_FAILURE], 400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    private function existMealLogByIdAndUserId(int $id, int $userId): bool
    {
        try {
            $meal = MealLogs::where(['id' => $id, 'user_id' => $userId])->first();
            if ($meal) {
                return true;
            }
        } catch (Exception $exception) {
            response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
            return true;
        }
        return false;
    }

    public function validateMealType($mealType, $continentCapital)
    {
        try {

            $timezone = new DateTimeZone($continentCapital);
            $datetime = new DateTime('now', $timezone);
            $hour = $datetime->format('H');

            switch ($mealType) {
                case 'Breakfast':
                    if ($hour >= 12 && $hour < 16) {
                        $mealType = 'Lunch';
                    } elseif ($hour >= 16) {
                        $mealType = 'Dinner';
                    }
                    break;
                case 'Lunch':
                    if ($hour < 12) {
                        $mealType = 'Breakfast';
                    } elseif ($hour >= 16) {
                        $mealType = 'Dinner';
                    }
                    break;
                case 'Dinner':
                    if ($hour < 16 && $hour >= 12) {
                        $mealType = 'Lunch';
                    }else if ($hour < 12){
                        $mealType = 'Breakfast';
                    }
                    break;
                case 'Morning snack':
                    if ($hour >= 12 && $hour < 16) {
                        $mealType = 'Afternoon snack';
                    }else if ($hour >= 16){
                        $mealType = 'Evening snack';
                    }
                    break;
                case 'Afternoon snack':
                    if ($hour < 12) {
                        $mealType = 'Morning snack';
                    } elseif ($hour >= 16) {
                        $mealType = 'Evening snack';
                    }
                    break;
                case 'Evening snack':
                    if ($hour < 16 && $hour >= 12) {
                        $mealType = 'Afternoon snack';
                    } elseif ($hour < 12) {
                        $mealType = 'Morning snack';
                    }
                    break;
                default:
                    break;
            }

            return $mealType;

        } catch (Exception $exception) {
            return null;
        }
    }

}
