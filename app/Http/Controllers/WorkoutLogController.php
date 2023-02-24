<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Models\WorkoutLog;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkoutLogController extends Controller
{
    public function index()
    {
        //Get Last 30 days workout logs
    }

    public function store(Request $request)
    {
        //Add new workout log
    }

    public function show(string $id)
    {
        //show workout log by id
    }

    public function update(Request $request, string $id)
    {
        //Updated workout log
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $user = auth()->user();
            //Check if user is admin Only admin can delete logs
            if ($user['role'] != 'ROLE_ADMIN'){
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $result = WorkoutLog::where('id',$id)->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETED_WORKOUT_LOG_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETED_WORKOUT_LOG_FAILURE],400);
        }catch (QueryException $exception){
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }
}
