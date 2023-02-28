<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Http\Requests\Water\AddWaterRequest;
use App\Http\Requests\Water\UpdateWaterRequest;
use App\Models\Water;
use App\Utils\AppHelpers;
use DateTime;
use DateTimeZone;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class WaterController extends Controller
{
    public function todayTotalMl(): JsonResponse
    {
        try {
            $todayDate = AppHelpers::getCurrentDate('Y-m-d');
            $userId = auth()->user()->getAuthIdentifier();
            $waterIntakes = DB::table('waters')
                ->select(DB::raw('id, time as today_time, DATE_FORMAT(time, "%H:%i") as time, amount'))
                ->where('user_id', $userId)
                ->whereRaw("DATE(time) = ?", [$todayDate])
                ->orderBy('time')
                ->get();

            $totalWaterIntake = $waterIntakes->sum('amount');

            // Format the individual water intake entries as objects
            $waterIntakeList = $waterIntakes->map(function($item) {
                return ['id' => $item->id,
                    'time' => $item->time,
                    'today_time' => $item->today_time,
                    'amount' => $item->amount,
                    ];
            });

            // Combine the total and individual water intake into an associative array
            $waterIntakeToday = [
                'totalIntakeWater' => $totalWaterIntake,
                'waterIntakeList' => $waterIntakeList,
            ];

            return response()->json($waterIntakeToday);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function index(): JsonResponse
    {
        //Get Last 30 days water intake logs
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $waterIntakes = DB::table('waters')
                ->where('user_id', $userId)
                ->whereBetween('time', [
                    now()->subDays(30)->format('Y-m-d H:i:s'),
                    now()->addDay()->format('Y-m-d H:i:s')])
                ->get();
            //Adding 1 day in future because of users timezones.
            // The server is london and if you are from Bulgaria the last 2 hours data is missing if used now()
            $intakesByDay = $waterIntakes->groupBy(function ($intake) {
                return Carbon::make($intake->time)->format('Y-m-d');
            });

            $result = [];
            foreach ($intakesByDay as $date => $intakes) {
                $intakesByTime = $intakes->sortBy('time');

                $resultItem = [
                    'date' => $date,
                    'intakes' => []
                ];

                foreach ($intakesByTime as $intake) {
                    $resultItem['intakes'][] = [
                        'amount' => $intake->amount,
                        'time' => Carbon::make($intake->time)->format('H:i')
                    ];
                }

                $result[] = $resultItem;
            }

            if ($result) {
                return response()->json($result);
            }
            return response()->json(['message' => Messages::WATER_LOGS_NOT_EXIST], 400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function store(AddWaterRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $userId = auth()->user()->getAuthIdentifier();
            $validatedData['user_id'] = $userId;

            //Set the timezone:
            //TODO: make the time zone dynamic or save user country in registration or when want to use the health part of the app
            $timezone = new DateTimeZone('Europe/Sofia');
            $datetime = new DateTime('now', $timezone);
            $current_datetime = $datetime->format('Y-m-d H:i:s');

            $validatedData['time'] = $current_datetime;

            $resultId = DB::table('waters')->insertGetId($validatedData);
            if ($resultId) {
                $addedWater = DB::table('waters')
                    ->where(['id' => $resultId])->first();
                return response()->json([
                    'message' => Messages::ADD_WATER_LOG_SUCCESS,
                    'addedWater' => $addedWater
                ], 201);
            }
            return response()->json(['message' => Messages::ADD_WATER_LOG_FAILURE], 400);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $waterIntake = DB::table('waters')
                ->where(['id' => $id])
                ->first();
            if ($waterIntake) {
                return response()->json($waterIntake);
            }
            return response()->json([
                'message' => Messages::WATER_LOGS_NOT_EXIST,
            ], 400);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(UpdateWaterRequest $request, string $id): JsonResponse
    {
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $validatedData = $request->validated();
            //Check if exercise exist
            if (!$this->waterLogExistById($id, $userId)) {
                return response()->json([
                    'message' => Messages::WATER_LOGS_NOT_EXIST,
                ], 400);
            }
            $result = DB::table('waters')
                ->where(['id' => $id, 'user_id' => $userId])
                ->update($validatedData);
            if ($result) {
                return response()->json(['message' => Messages::UPDATE_WATER_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::UPDATE_WATER_LOG_FAILURE], 400);

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

            $result = Water::where(['id' => $id, 'user_id' => $userId])->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETE_WATER_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETE_WATER_LOG_FAILURE], 400);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    private function waterLogExistById(int $id, int $userId): bool
    {
        try {
            $waterLog = Water::where(['id' => $id, 'user_id' => $userId])->first();
            if ($waterLog) {
                return true;
            }
        } catch (QueryException $exception) {
            response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
            return true;
        }
        return false;
    }
}
