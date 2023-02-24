<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Http\Requests\Exercises\AddExerciseRequest;
use App\Http\Requests\Exercises\UpdateExerciseRequest;
use App\Models\Exercise;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $exercises = DB::table('exercises')->get('*');
            if ($exercises) {
                return response()->json($exercises);
            }
            return response()->json([
                'message' => Messages::NO_EXERCISES,
            ], 400);
        } catch (QueryException $queryException) {
            return response()->json([
                'message' => $queryException->getMessage()
            ],400);
        }
    }

    public function store(AddExerciseRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            //Check if the user is admin
            if ($user['role'] != 'ROLE_ADMIN'){
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $validatedData = $request->validated();
            //Check if exercise name exist
            if ($this->exerciseExistByName($validatedData['name'])) {
                return response()->json([
                    'message' => Messages::EXERCISE_EXIST,
                ], 400);
            }
            DB::table('exercises')->insert([$validatedData]);
            return response()->json([
                'message' => Messages::EXERCISE_ADDED_SUCCESS,
            ], 201);
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
            $exercise = DB::table('exercises')
                ->where(['id' => $id])
                ->first('*');
            if ($exercise) {
                return response()->json($exercise);
            }
            return response()->json([
                'message' => Messages::EXERCISE_NOT_EXIST,
            ], 400);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(UpdateExerciseRequest $request, int $id): JsonResponse
    {
        try {
            $user = auth()->user();
            //Check if user is admin
            if ($user['role'] != 'ROLE_ADMIN'){
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $validatedData = $request->validated();
            //Check if exercise exist
            if (!$this->exerciseExistById($id)) {
                return response()->json([
                    'message' => Messages::EXERCISE_NOT_EXIST,
                ], 400);
            }
            DB::table('exercises')
                ->where(['id' => $id])
                ->update($validatedData);
            return response()->json([
                'message' => Messages::EXERCISE_UPDATED_SUCCESS,
            ], 201);
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
            //Check if user is admin
            if ($user['role'] != 'ROLE_ADMIN'){
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            Exercise::where('id',$id)
                ->delete();
        }catch (QueryException $exception){
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }

        return response()->json(['message' => Messages::DELETED_EXERCISE_SUCCESS]);
    }

    private function exerciseExistByName(string $name): bool
    {
        try {
            $exercise = Exercise::where(['name' => $name])->first();
            if ($exercise){ return true; }
        } catch (QueryException $exception) {
            response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
            return true;
        }
        return false;
    }
    private function exerciseExistById(int $id): bool
    {
        try {
            $exercise = Exercise::where(['id' => $id])->first();
            if ($exercise){ return true; }
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
