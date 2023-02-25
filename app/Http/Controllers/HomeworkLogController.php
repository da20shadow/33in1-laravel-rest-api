<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Constants\Health\DefaultBodyComposition;
use App\Constants\Health\HealthConvertingFormulas;
use App\Http\Requests\HomeworkLog\AddHomeworkLogRequest;
use App\Http\Requests\HomeworkLog\UpdateHomeworkLogRequest;
use App\Models\BodyComposition;
use App\Models\HomeworkLog;
use DateTime;
use DateTimeZone;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class HomeworkLogController extends Controller
{
    public function index(): JsonResponse
    {
        //Get Last 30 days homework logs
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $workoutList = DB::table('homework_logs')
                ->where('user_id', $userId)
                ->whereBetween('start_time', [
                    now()->subDays(30)->format('Y-m-d H:i:s'),
                    now()->addDay()->format('Y-m-d H:i:s')])
                ->orderBy('start_time')
                ->get();
            if ($workoutList->isNotEmpty()) {
                return response()->json($workoutList);
            }
            return response()->json(['message' => Messages::HOMEWORK_LOG_NOT_EXIST], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    //Sorted Ordered in Logs by day
    public function getHomeworkLogs(Request $request): JsonResponse
    {
        $user_id = $request->user()->id;

        $logs = HomeworkLog::where('user_id', $user_id)
            ->whereBetween('start_time', [
                now()->subDays(30)->startOfDay(),
                now()->addDay()->endOfDay()])
            ->with('homework')
            ->orderBy('start_time', 'asc')
            ->get();

        $grouped_logs = $logs->groupBy(function ($log) {
            return Carbon::make($log->start_time)->format('Y-m-d');
        });

        $result = [];

        foreach ($grouped_logs as $date => $logs) {
            $day_logs = [];

            foreach ($logs as $log) {
                $homework_name = $log->homework->name;
                $start_time = Carbon::make($log->start_time)->format('H:i');
                $total_minutes = $log->minutes;
                $calories_burned = $log->calories;

                if (isset($day_logs[$homework_name])) {
                    $day_logs[$homework_name]['minutes'] += $total_minutes;
                    $day_logs[$homework_name]['calories'] += $calories_burned;
                } else {
                    $day_logs[$homework_name] = [
                        'work_name' => $homework_name,
                        'start_time' => $start_time,
                        'minutes' => $total_minutes,
                        'calories' => $calories_burned,
                    ];
                }
            }

            $day_logs = array_values($day_logs);

            usort($day_logs, function ($a, $b) {
                return strcmp($a['start_time'], $b['start_time']);
            });

            $result[] = [
                'date' => $date,
                'logs' => $day_logs,
            ];
        }

        return response()->json($result);
    }

    public function store(AddHomeworkLogRequest $request): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $validatedData = $request->validated();

            //Calculate burned calories
            $homeworkLog = $this->calculateBurnedCaloriesAndCreateHomeworkLog($userId, $validatedData);
            if (!$homeworkLog) {
                return response()->json(['message' => Messages::ADD_HOMEWORK_LOG_FAILURE], 400);
            }
            //Insert the homework
            $result = DB::table('homework_logs')->insert($homeworkLog);
            if ($result) {
                return response()->json(['message' => Messages::ADD_HOMEWORK_LOG_SUCCESS], 201);
            }
            return response()->json(['message' => Messages::ADD_HOMEWORK_LOG_FAILURE], 400);

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
            $homework = DB::table('homework_logs')->where(['id' => $id, 'user_id' => $userId])->first();
            if ($homework) { return response()->json($homework); }
            return response()->json(['message' => Messages::HOMEWORK_LOG_NOT_EXIST],400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    public function update(UpdateHomeworkLogRequest $request, int $id): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $workout = HomeworkLog::where(['id' => $id, 'user_id' => $userId])->first();
            if (!$workout) {
                return response()->json([
                    'message' => Messages::HOMEWORK_LOG_NOT_EXIST,
                ], 400);
            }

            //Create Homework Log Data To Update!!!
            $validatedData = $request->validated();
            $homeworkLog = $this->calculateBurnedCaloriesAndCreateHomeworkLog($userId, $validatedData);
            if (!$homeworkLog) {
                return response()->json(['message' => Messages::UPDATE_HOMEWORK_LOG_FAILURE], 400);
            }

            $result = DB::table('homework_logs')
                ->where(['id' => $id, 'user_id' => $userId])
                ->update($homeworkLog);
            if ($result) {
                return response()->json(['message' => Messages::UPDATE_HOMEWORK_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::UPDATE_HOMEWORK_LOG_FAILURE], 400);
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
            $result = HomeworkLog::where('id', $id)->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETE_HOMEWORK_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETE_HOMEWORK_LOG_FAILURE], 400);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    private function calculateBurnedCaloriesAndCreateHomeworkLog(int $userId, array $validatedData): ?array
    {
        //TODO: make one method for both workout and homeworks because there is duplicated code!
        try {
            $homeworkId = $validatedData['homework_id'];
            $minutes = $validatedData['minutes'];

            //Check if exercise exists
            $homeworkExist = HomeworkController::getHomeworkById($homeworkId);
            if (!$homeworkExist) {
                return null;
            }
            $MET = $homeworkExist['met'];
            if ($MET == null) { return null; }

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

            $homeworkLog = [
                'user_id' => $userId,
                'minutes' => $minutes,
                'homework_id' => $homeworkId
            ];

            if (isset($validatedData['start_time'])) {
                $startTime = date($validatedData['start_time']);
                $homeworkLog['start_time'] = $startTime;
            }else{
                $homeworkLog['start_time'] = new \DateTime();
            }

            //Calculate burned calories
            $burnedCalories = null;
            if ($minutes) {
                $calPerMinute = HealthConvertingFormulas::calculateBurnedCaloriesPerMinute($MET, $personKg);
                $burnedCalories = $calPerMinute * $minutes;
            }
            if (!$burnedCalories) { return null; }

            $homeworkLog['calories'] = $burnedCalories;
            //TODO: make the timezone dynamic or get the Country from user
            $timezone = new DateTimeZone('Europe/Sofia');
            $datetime = new DateTime('now', $timezone);
            $current_datetime = $datetime->format('Y-m-d H:i:s');
            $homeworkLog['start_time'] = $current_datetime;

            return $homeworkLog;
        } catch (\Exception $exception) {
            //TODO: Log the error
            return null;
        }

    }
}
