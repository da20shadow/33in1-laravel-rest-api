<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Http\Requests\Water\AddWaterRequest;
use App\Http\Requests\Water\UpdateWaterRequest;
use App\Models\Water;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class WaterController extends Controller
{
    public function index(): JsonResponse
    {
        //Get Last 30 days water intake logs
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $workoutList = DB::table('waters')
                ->where('user_id', $userId)
                ->whereBetween('time', [now()->subDays(30), now()])
                ->get();
            if ($workoutList->isNotEmpty()) {
                return response()->json($workoutList);
            }
            return response()->json(['message' => Messages::WATER_LOGS_NOT_EXIST], 400);
        } catch (Exception $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    public function store(AddWaterRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $userId = auth()->user()->getAuthIdentifier();
            $validatedData['user_id']= $userId;
            $validatedData['time'] = new \DateTime();

            $result = DB::table('waters')->insert([$validatedData]);
            if ($result) {
                return response()->json(['message' => Messages::ADD_WATER_LOG_SUCCESS], 201);
            }
            return response()->json(['message' => Messages::ADD_WATER_LOG_FAILURE], 400);

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
        if (!$this->waterLogExistById($id,$userId)) {
            return response()->json([
                'message' => Messages::WATER_LOGS_NOT_EXIST,
            ], 400);
        }
        $result = DB::table('waters')
            ->where(['id' => $id,'user_id' => $userId])
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
            return response()->json(['message' => Messages::DELETE_WATER_LOG_FAILURE],400);
        }catch (QueryException $exception){
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    private function waterLogExistById(int $id, int $userId): bool
    {
        try {
            $waterLog = Water::where(['id' => $id,'user_id' => $userId])->first();
            if ($waterLog){ return true; }
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
