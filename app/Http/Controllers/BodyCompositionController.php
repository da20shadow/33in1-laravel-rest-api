<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Http\Requests\BodyComposition\AddBodyCompositionRequest;
use App\Http\Requests\BodyComposition\UpdateBodyCompositionRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BodyCompositionController extends Controller
{
    public function index(): JsonResponse
    {
        //Get Body composition info
        try {
            $userId = auth()->user()->getAuthIdentifier();
            $bodyComposition = DB::table('body_compositions')
                ->where(['user_id' => $userId])
                ->first('*');
            return response()->json($bodyComposition);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function store(AddBodyCompositionRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $userId = auth()->user()->getAuthIdentifier();
            $validatedData['user_id'] = $userId;
            //Add body composition info
            DB::table('body_compositions')->insert([$validatedData]);
            return response()->json([
                'message' => Messages::SUCCESS_ADDED_BODY_COMPOSITION,
            ], 201);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(UpdateBodyCompositionRequest $request): JsonResponse
    {
        //Update body composition
        try {
            $validatedData = $request->validated();
            $userId = auth()->user()->getAuthIdentifier();
            DB::table('body_compositions')
                ->where(['user_id' => $userId])
                ->update($validatedData);
            return response()->json([
                'message' => Messages::SUCCESS_UPDATED_BODY_COMPOSITION,
            ]);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }
}
