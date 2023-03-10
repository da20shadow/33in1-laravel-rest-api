<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Http\Requests\Exercises\AddExerciseRequest;
use App\Http\Requests\Exercises\UpdateExerciseRequest;
use App\Models\Exercise;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10); // Set the number of records per page, default to 10.
            $query = $request->input('query', ''); // Get the search query parameter.
            $type = $request->input('type', ''); // Get the type parameter.

            $exercises = Exercise::where('name', 'like', "%$query%") // Filter exercises by name if query parameter is present.
            ->when($type, function ($query) use ($type) {
                return $query->where('type', $type); // Filter exercises by type if type parameter is present.
            })->paginate($perPage); // Paginate the results.

            if ($exercises->isNotEmpty()) {
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
            $result = DB::table('exercises')->insert([$validatedData]);
            if ($result) {
                return response()->json(['message' => Messages::EXERCISE_ADDED_SUCCESS], 201);
            }
            return response()->json(['message' => Messages::EXERCISE_ADDED_FAILURE], 400);

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
                ->first();
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
            $result = DB::table('exercises')
                ->where(['id' => $id])
                ->update($validatedData);
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
            //Check if user is admin
            if ($user['role'] != 'ROLE_ADMIN'){
                return response()->json([
                    'message' => Messages::NO_RIGHTS,
                ], 400);
            }
            $result = Exercise::where('id',$id)->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETED_EXERCISE_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETED_EXERCISE_FAILURE],400);
        }catch (QueryException $exception){
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }

    }

    public static function exerciseExistByName(string $name): bool
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
    public static function exerciseExistById(int $id): bool
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
    public static function getExerciseById(int $id)
    {
        try {
            return Exercise::where(['id' => $id])->first();
        } catch (QueryException $exception) {
            response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
            return null;
        }
    }
}
