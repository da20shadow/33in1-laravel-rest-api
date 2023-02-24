<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Constants\Health\DefaultBodyComposition;
use App\Constants\Health\HealthConvertingFormulas;
use App\Http\Requests\WorkoutLog\AddWorkoutLogRequest;
use App\Http\Requests\WorkoutLog\UpdateWorkoutLogRequest;
use App\Models\BodyComposition;
use App\Models\WorkoutLog;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class WorkoutLogController extends Controller
{
    //TODO: To implement buttons like samsung health to track minutes of doing the workout instead of reps
    public function index(): JsonResponse
    {
        //Get Last 30 days workout logs
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $workoutList = DB::table('workout_logs')
                ->where('user_id', $userId)
                ->whereBetween('start_time', [now()->subDays(30), now()])
                ->get();
            if ($workoutList->isNotEmpty()) {
                return response()->json($workoutList);
            }
            return response()->json(['message' => Messages::WORKOUT_LOG_NOT_EXIST], 400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    public function store(AddWorkoutLogRequest $request): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $validatedData = $request->validated();

            //Calculate burned calories
            $workoutLog = $this->calculateBurnedCaloriesAndCreateWorkoutLog($userId, $validatedData);
            if (!$workoutLog) {
                return response()->json(['message' => Messages::ADD_WORKOUT_LOG_FAILURE], 400);
            }
            //Insert the workout
            $result = DB::table('workout_logs')->insert($workoutLog);
            if ($result) {
                return response()->json(['message' => Messages::ADD_WORKOUT_LOG_SUCCESS], 201);
            }
            return response()->json(['message' => Messages::ADD_WORKOUT_LOG_FAILURE], 400);

        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $workout = DB::table('workout_logs')->where(['id' => $id, 'user_id' => $userId])->first();
            if ($workout) { return response()->json($workout); }
            return response()->json(['message' => Messages::WORKOUT_LOG_NOT_EXIST],400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    public function update(UpdateWorkoutLogRequest $request, int $id): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $workout = WorkoutLog::where(['id' => $id, 'user_id' => $userId])->first();
            if (!$workout) {
                return response()->json([
                    'message' => Messages::WORKOUT_LOG_NOT_EXIST,
                ], 400);
            }

            //Create Workout Log Data To Update!!!
            $validatedData = $request->validated();
            $workoutLog = $this->calculateBurnedCaloriesAndCreateWorkoutLog($userId, $validatedData);
            if (!$workoutLog) {
                return response()->json(['message' => Messages::UPDATE_WORKOUT_LOG_FAILURE], 400);
            }

            $result = DB::table('workout_logs')
                ->where(['id' => $id, 'user_id' => $userId])
                ->update($workoutLog);
            if ($result) {
                return response()->json(['message' => Messages::EXERCISE_UPDATED_SUCCESS]);
            }
            return response()->json(['message' => Messages::EXERCISE_UPDATED_FAILURE], 400);
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
            $user = auth()->user();
            //Check if user is admin Only admin can delete logs
            if ($user['role'] != 'ROLE_ADMIN') {
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $result = WorkoutLog::where('id', $id)->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETED_WORKOUT_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETED_WORKOUT_LOG_FAILURE], 400);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    private function calculateBurnedCaloriesAndCreateWorkoutLog(int $userId, $validatedData): ?array
    {
        try {
            $exerciseId = $validatedData['exercise_id'];
            $intensityInput = $validatedData['intensity'];
            $reps = $validatedData['reps'] ?? false;
            $minutes = $validatedData['minutes'] ?? false;

            //Create Workout Log
            //TODO: when implement start workout button that will count minutes to remove the start_datefrom here
            $workoutLog = [
                'user_id' => $userId,
                'exercise_id' => $exerciseId
            ];
            if (isset($validatedData['start_time'])) {
                $startTime = date($validatedData['start_time']);
                $workoutLog['start_time'] = $startTime;
            }else{
                $workoutLog['start_time'] = new \DateTime();
            }

            //Get Body composition kg or set default kg
            $bodyComposition = BodyComposition::where(['user_id' => $userId])->first();
            $personKg = null;
            if ($bodyComposition && isset($bodyComposition['weight'])) {
                $personKg = $bodyComposition['weight'];
            } else if (isset($bodyComposition['gender'])) {
                if ($bodyComposition['gender'] == 'male') {
                    $personKg = DefaultBodyComposition::DEFAULT_MALE_KG;
                } else if ($bodyComposition['gender'] == 'female') {
                    $personKg = DefaultBodyComposition::DEFAULT_FEMALE_KG;
                }
            } else {
                $personKg = DefaultBodyComposition::DEFAULT_UNKNOWN_KG;
            }

            //Check if exercise exists
            $exerciseExist = ExerciseController::getExerciseById($exerciseId);
            if (!$exerciseExist) {
                return null;
            }

            //Setting workout intensity
            $MET = null;
            $secondsForOneRep = null;
            if ($intensityInput == 'slow') {
                $MET = $exerciseExist['slow_met'];
                $secondsForOneRep = 5;
            } else if ($intensityInput == 'moderate') {
                $MET = $exerciseExist['moderate_met'];
                $secondsForOneRep = 3;
            } else if ($intensityInput == 'energetic') {
                $MET = $exerciseExist['energetic_met'];
                $secondsForOneRep = 1;
            }

            if ($MET == null) {
                return null;
            }

            //Calculate burned calories
            $burnedCalories = null;
            if ($reps) {
                $calPerRep = HealthConvertingFormulas::calculateBurnedCaloriesPerRep($MET, $personKg, $secondsForOneRep);
                $burnedCalories = $calPerRep * $reps;
                $workoutLog['reps'] = $reps;
                $workoutLog['minutes'] = null;
            } else if ($minutes) {
                $calPerMinute = HealthConvertingFormulas::calculateBurnedCaloriesPerMinute($MET, $personKg);
                $burnedCalories = $calPerMinute * $minutes;
                $workoutLog['reps'] = null;
                $workoutLog['minutes'] = $minutes;
            }
            if (!$burnedCalories) {
                return null;
            }

            $workoutLog['calories'] = $burnedCalories;
            return $workoutLog;

        } catch (\Exception $exception) {
            //TODO: Log the error
            return null;
        }
    }
}
