<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Http\Requests\BodyComposition\AddBodyCompositionRequest;
use App\Http\Requests\BodyComposition\UpdateBodyCompositionRequest;
use App\Models\BodyComposition;
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
            $userId = auth()->user()->getAuthIdentifier();
            if ($this->bodyCompositionExist($userId)) {
                return response()->json([
                    'message' => Messages::BODY_COMPOSITION_EXIST,
                ], 400);
            }
            $validatedData = $request->validated();
            $validatedData['user_id'] = $userId;
            //Add body composition info
            DB::table('body_compositions')->insert([$validatedData]);
            return response()->json([
                'message' => Messages::ADDED_BODY_COMPOSITION_SUCCESS,
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
                'message' => Messages::UPDATED_BODY_COMPOSITION_SUCCESS,
            ]);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    private function bodyCompositionExist(int $userId): bool
    {
        try {
            $bodyComp = BodyComposition::where(['user_id' => $userId])->first();
            echo($bodyComp);
            if ($bodyComp){ return true; }
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
