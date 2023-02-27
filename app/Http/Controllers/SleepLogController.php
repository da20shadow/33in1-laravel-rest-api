<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Constants\Health\DefaultBodyComposition;
use App\Constants\Health\METs\DefaultMETs;
use App\Http\Requests\SleepLog\AddSleepLogRequest;
use App\Http\Requests\SleepLog\UpdateSleepLogRequest;
use App\Models\BodyComposition;
use App\Models\SleepLog;
use App\Utils\AppHelpers;
use Carbon\CarbonInterval;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SleepLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier(); // Get the user ID from the authenticated user
            $days = $request->input('days', '7'); //Get the number of days from the query parameter, defaulting to 7

            if ($days < 1) { $days = 1; }

            //TODO: Add dynamic timezone
            (new Carbon)->setTimezone('Europe/Sofia');
            // Calculate the date range for the sleep logs
            $startDate = Carbon::today()->subDays($days);
            $endDate = Carbon::today()->addDay();

            // Get the sleep logs for the user within the date range
            $sleepLogs = SleepLog::where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();

            // Initialize an array to store the formatted sleep logs
            $formattedSleepLogs = [];

            // Loop through the sleep logs and format them
            foreach ($sleepLogs as $sleepLog) {
                $sleepStartTime = Carbon::parse($sleepLog->sleep_start_time);
                $sleepEndTime = Carbon::parse($sleepLog->sleep_end_time);

                // Check if start sleep and end sleep times are on different days
                if ($sleepStartTime->isSameDay($sleepEndTime)) {
                    $date = $sleepStartTime->format('D jS M Y');
                    $sleepEnd = $sleepEndTime->format('H:i (D)');
                } else {
                    $date = $sleepStartTime->format('D jS M Y') . ' - ' . $sleepEndTime->format('D jS M Y');
                    $sleepEnd = $sleepEndTime->format('H:i (D jS M Y)');
                }

                $sleepStart = $sleepStartTime->format('H:i (D)');
                $sleepDuration = $sleepStartTime->diff($sleepEndTime);
                $sleepDurationFormatted = CarbonInterval::seconds($sleepDuration->s)->minutes($sleepDuration->i)->hours($sleepDuration->h)->forHumans(['short' => true]);
                $caloriesBurned = $this->calculateCaloriesBurned($userId, $sleepDuration->h);
                $formattedSleepLog = [
                    'date' => $date,
                    'sleepStart' => $sleepStart,
                    'sleepEnd' => $sleepEnd,
                    'sleepDuration' => $sleepDurationFormatted,
                    'caloriesBurned' => $caloriesBurned
                ];
                $formattedSleepLogs[] = $formattedSleepLog;
            }
            // Return the formatted sleep logs
            return response()->json($formattedSleepLogs);

        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function store(AddSleepLogRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $userId = auth()->user()->getAuthIdentifier();

            //TODO: TO ADD 'date' and CHECK IF IN $validatedData HAS 'date'
            // IF THERE IS DATE THIS MEAN THE USER TRY TO ADD SLEEP LOG FOR ANOTHER DAY

            //TODO: make the timezone dynamic or get the Country from user
            $today = AppHelpers::getCurrentDate('Y-m-d', 'Europe/Sofia');

            //Check if there is already added log for today
            $todayLog = SleepLog::where('user_id', $userId)->whereRaw("DATE(date) = ?", [$today])->first();
            if ($todayLog) {
                return response()->json([
                    'message' => Messages::SLEEP_LOG_EXIST,
                ], 400);
            }

            $current_datetime = AppHelpers::getCurrentDate();
            $validatedData['date'] = $current_datetime;
            $validatedData['user_id'] = $userId;

//            if ($this->validateSleepOverlap($validatedData)->fails()) {
//                return response()->json([
//                    'message' => Messages::ADD_SLEEP_LOG_FAILURE,
//                ], 400);
//            }
            $result = DB::table('sleep_logs')->insert($validatedData);
            if ($result) {
                return response()->json([
                    'message' => Messages::ADD_SLEEP_LOG_SUCCESS,
                ], 201);
            }

            return response()->json([
                'message' => Messages::ADD_SLEEP_LOG_FAILURE,
            ], 400);

        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }

    }

    public function startSleep(): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            //TODO: make the timezone dynamic or get the Country from user
            $today = AppHelpers::getCurrentDate('Y-m-d', 'Europe/Sofia');
            //Check if there is already added log for today
            $existing_sleep = SleepLog::where('user_id', $userId)
                ->whereRaw("DATE(date) = ?", [$today])->first();

            if ($existing_sleep && $existing_sleep->sleep_end_time == null) {
                $message = 'There is already a sleep session in progress.';
                return response()->json(['message' => $message,'sleep_log' => $existing_sleep,], 409);
            }

            $yesterday = date_create($today)->modify('-1 days')->format('Y-m-d');
            //Check if there is already added log for yesterday
            $existing_sleep = SleepLog::where('user_id', $userId)
                ->whereRaw("DATE(date) = ?", [$yesterday])->first();
            if ($existing_sleep && $existing_sleep->sleep_end_time == null) {
                $message = 'There is already a sleep session in progress.';
                return response()->json(['message' => $message,'sleep_log' => $existing_sleep,], 409);
            }

            $sleep_log = [
                'user_id' => $userId,
                'date' => $today,
                'sleep_start_time' => AppHelpers::getCurrentDate(),
            ];

            DB::table('sleep_logs')->insert($sleep_log);

            return response()->json([
                'message' => Messages::SLEEP_LOG_STARTED_SUCCESS,
                'sleep_log' => $sleep_log,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function stopSleep(): JsonResponse
    {
        try {
            //Checks only for Today and Yesterday dates!
            $existing_sleep = $this->getLastSleepLog();

            if (!$existing_sleep) {
                return response()->json([
                    'message' => 'There is no sleep session in progress',
                ], 404);
            }

            $stoppedSleep = [
                'sleep_end_time' => AppHelpers::getCurrentDate()
            ];

            $userId = auth()->user()->getAuthIdentifier();
            DB::table('sleep_logs')
                ->where('id',$existing_sleep->id)
                ->where('user_id',$userId)
                ->update($stoppedSleep);

            $stoppedLog = DB::table('sleep_logs')->where('id',$existing_sleep->id)->first();
            return response()->json([
                'message' => 'Sleep session stopped successfully',
                'sleepLog' => $stoppedLog,
            ], 200);

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
            $sleepLog = SleepLog::where(['id' => $id, 'user_id' => $userId]);
            if ($sleepLog) {
                return response()->json($sleepLog);
            }
            return response()->json([
                'message' => Messages::SLEEP_LOG_NOT_FOUND,
            ], 400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(UpdateSleepLogRequest $request, int $id): JsonResponse
    {
        //TODO: make validations to be sure that there is no overlap sleep
        try {
            $userId = auth()->user()->getAuthIdentifier();
            // Find the sleep log by its ID
            $sleepLog = SleepLog::where(['id' => $id, 'user_id' => $userId])->first();

            if (!$sleepLog) {
                return response()->json([
                    'message' => Messages::UPDATE_SLEEP_LOG_FAILURE,
                ], 400);
            }

            // Validate the request data
            $validatedData = $request->validated();

            // Check if sleep_end_time is being updated and is before sleep_start_time
            if (isset($validatedData['sleep_end_time'])) {
                $sleepStartTime = isset($validatedData['sleep_start_time'])
                    ? new DateTime($validatedData['sleep_start_time'])
                    : new DateTime($sleepLog->sleep_start_time);
                $sleepEndTime = new DateTime($validatedData['sleep_end_time']);
                if ($sleepEndTime < $sleepStartTime) {
                    return response()->json([
                        'message' => Messages::UPDATE_SLEEP_LOG_FAILURE,
                        'error' => 'sleep_end_time cannot be before sleep_start_time',
                    ], 400);
                }
            }

            // Check if nap_end_time is being updated and is before sleep_start_time
            if (isset($validatedData['nap_end_time'])) {
                $napStartTime = isset($validatedData['nap_start_time'])
                    ? new DateTime($validatedData['nap_start_time'])
                    : new DateTime($sleepLog->nap_start_time);
                $napEndTime = new DateTime($validatedData['nap_end_time']);
                if ($napEndTime < $napStartTime) {
                    return response()->json([
                        'message' => Messages::UPDATE_SLEEP_LOG_FAILURE,
                        'error' => 'nap_end_time cannot be before nap_start_time',
                    ], 400);
                }
            }

            // Update the sleep log with the validated data
            if (isset($validatedData['sleep_start_time'])) {
                DB::table('sleep_logs')
                    ->where(['id' => $id, 'user_id' => $userId])
                    ->update(['sleep_start_time' => $validatedData['sleep_start_time']]);
            }

            if (isset($validatedData['sleep_end_time'])) {
                DB::table('sleep_logs')
                    ->where(['id' => $id, 'user_id' => $userId])
                    ->update(['sleep_end_time' => $validatedData['sleep_end_time']]);
            }

            if (isset($validatedData['nap_start_time'])) {
                DB::table('sleep_logs')
                    ->where(['id' => $id, 'user_id' => $userId])
                    ->update(['nap_start_time' => $validatedData['nap_start_time']]);
            }

            if (isset($validatedData['nap_end_time'])) {
                DB::table('sleep_logs')
                    ->where(['id' => $id, 'user_id' => $userId])
                    ->update(['nap_ned_time' => $validatedData['nap_ned_time']]);
            }
            $sleepLog = SleepLog::where(['id' => $id, 'user_id' => $userId])->first();
            // Return a response
            return response()->json([
                'message' => Messages::UPDATE_SLEEP_LOG_SUCCESS,
                'sleepLog' => $sleepLog,
            ]);
        } catch (Exception $exception) {
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
            //Check if user is admin
            if ($user['role'] != 'ROLE_ADMIN') {
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $result = SleepLog::where('id', $id)->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETE_SLEEP_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETE_SLEEP_LOG_FAILURE], 400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }


    //Check if there is not stopped log for more than 20 hours
    public function checkAndStopLastStartedSleepLogIfTooLong($userId = null): ?JsonResponse
    {
        try {
            if ($userId == null) {
                $userId = auth()->user()->getAuthIdentifier();
            }
            // Get the last sleep log for the user that is started but not stopped
            $sleep_log = DB::table('sleep_logs')
                ->where('user_id', $userId)
                ->whereNull('sleep_end_time')
                ->orderBy('date', 'desc')
                ->first();

            if ($sleep_log) {
                //TODO: Add dynamic timezone
                (new Carbon)->setTimezone('Europe/Sofia');
                // Calculate the duration of the sleep log so far
                $start_time = Carbon::parse($sleep_log->sleep_start_time);
                $duration = $start_time->diffInHours(Carbon::now());

                // If the duration is more than 20 hours, stop the sleep log and set the sleep end time to 8 hours after the start time
                if ($duration >= 20) {
                    $stop_time = $start_time->copy()->addHours(8);
                    DB::table('sleep_logs')
                        ->where('id', $sleep_log->id)
                        ->update(['sleep_end_time' => $stop_time,
                            'date' => $start_time->format('Y-m-d')]);

                    // Return the stopped sleep log
                    return response()->json([
                        'message' => 'There was sleep log that you forget to stop!',
                        'stoppedSleepLog' => $sleep_log
                    ]);
                }
            }

            return response()->json(['message' => 'No sleep in progress']);

        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function getLastSleepLogWithNullEndTime(): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();

            $lastSleepLog = SleepLog::where([
                'user_id' => $userId,
                'sleep_end_time' => NULL,
            ])->latest('date')->first();

            if (!$lastSleepLog) {
                return response()->json([
                    'message' => Messages::LAST_SLEEP_LOG_NOT_FOUND,
                ]);
            }

            return response()->json(['sleepLog' => $lastSleepLog]);

        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function getTodaySleepLog(): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $today = Carbon::now('Europe/Sofia')->format('Y-m-d');

            $sleepLog = SleepLog::where([
                ['user_id', '=', $userId],
                ['sleep_start_time', '>=', $today],
            ])->whereDate('date', '=', $today)->first();

            if (!$sleepLog) {
                return response()->json([
                    'message' => Messages::SLEEP_LOG_NOT_FOUND,
                ]);
            }

            return response()->json(['sleepLog' => $sleepLog]);

        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage(),
            ], 400);
        }
    }


    public function getLastSleepLog()
    {
        $userId = auth()->user()->getAuthIdentifier();
        //TODO: make timezone dynamic
        // Set the timezone to 'Europe/London'
        (new Carbon)->setTimezone('Europe/Sofia');
        // Get the current date in the 'Europe/Sofia' timezone
        $today = Carbon::today()->format('Y-m-d');
        // Get yesterday's date in the 'Europe/Sofia' timezone
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // Check for an existing log on the current date and the previous date
        return DB::table('sleep_logs')->where(['user_id' => $userId])
            ->whereNull('sleep_end_time')
            ->where(function ($query) use ($today, $yesterday) {
                $query->whereRaw("DATE(date) = ?", [$today])
                    ->orWhereRaw("DATE(date) = ?", [$yesterday]);
            })
            ->orderBy('date', 'desc')
            ->first();
    }

    public function validateSleepOverlap(array $data): \Illuminate\Validation\Validator
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer',
            'date' => 'required|date',
            'sleep_start_time' => 'required|date_format:H:i',
            'sleep_end_time' => 'required|date_format:H:i|after:sleep_start_time',
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        $sleepLogs = DB::table('sleep_logs')
            ->where('user_id', $data['user_id'])
            ->where('date', $data['date'])
            ->where(function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query->where('sleep_start_time', '<', $data['sleep_end_time'])
                        ->where('sleep_end_time', '>', $data['sleep_start_time']);
                })->orWhere(function ($query) use ($data) {
                    $query->where('sleep_start_time', '>=', $data['sleep_start_time'])
                        ->where('sleep_end_time', '<=', $data['sleep_end_time']);
                });
            })
            ->get();

        if ($sleepLogs->count() > 0) {
            return Validator::make([], ['sleep_start_time' => 'Sleep time overlaps with existing record']);
        }

        return $validator;
    }

    private function calculateCaloriesBurned(int $userId, float $sleepDurationHours): int
    {
        $userKg = BodyCompositionController::getUserKg($userId); // Get the user's weight in kilograms
        $met = DefaultMETs::SLEEPING; // The metabolic equivalent of sleeping is about 0.95 - 1.0
        $caloriesPerMinute = ($met * 3.5 * $userKg) / 200; // Formula to calculate calories burned per minute
        // Formula to calculate calories burned for the duration of sleep
        return round($caloriesPerMinute * $sleepDurationHours * 60);
    }

}
