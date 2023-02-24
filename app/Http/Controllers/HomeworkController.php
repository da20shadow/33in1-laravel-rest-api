<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Http\Requests\Homework\AddHomeworkRequest;
use App\Http\Requests\Homework\UpdatedHomeworkRequest;
use App\Models\Homework;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HomeworkController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $homework = DB::table('homework')->get();
            if ($homework->isNotEmpty()) {
                return response()->json($homework);
            }
            return response()->json([
                'message' => Messages::NO_HOMEWORK,
            ], 400);
        } catch (QueryException $queryException) {
            return response()->json([
                'message' => $queryException->getMessage()
            ],400);
        }
    }

    public function store(AddHomeworkRequest $request): JsonResponse
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
            if ($this->homeworkExistByName($validatedData['name'])) {
                return response()->json([
                    'message' => Messages::HOMEWORK_EXIST,
                ], 400);
            }
            $result = DB::table('homework')->insert([$validatedData]);
            if ($result) {
                return response()->json(['message' => Messages::HOMEWORK_ADDED_SUCCESS], 201);
            }
            return response()->json(['message' => Messages::HOMEWORK_ADDED_FAILURE], 400);

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
            $exercise = DB::table('homework')
                ->where(['id' => $id])->first();
            if ($exercise) {
                return response()->json($exercise);
            }
            return response()->json([
                'message' => Messages::HOMEWORK_NOT_EXIST,
            ], 400);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(UpdatedHomeworkRequest $request, string $id): JsonResponse
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
            if (!$this->homeworkExistById($id)) {
                return response()->json([
                    'message' => Messages::HOMEWORK_NOT_EXIST,
                ], 400);
            }
            $result = DB::table('homework')
                ->where(['id' => $id])
                ->update($validatedData);
            if ($result) {
                return response()->json(['message' => Messages::HOMEWORK_UPDATE_SUCCESS]);
            }
            return response()->json(['message' => Messages::HOMEWORK_UPDATE_FAILURE], 400);
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
            $result = Homework::where('id',$id)->delete();
            if ($result) {
                return response()->json(['message' => Messages::DELETE_HOMEWORK_SUCCESS]);
            }
            return response()->json(['message' => Messages::DELETE_HOMEWORK_FAILURE],400);
        }catch (QueryException $exception){
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }
    }

    private function homeworkExistByName(string $name): bool
    {
        try {
            $exercise = Homework::where(['name' => $name])->first();
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

    private function homeworkExistById(int $id): bool
    {
        try {
            $exercise = Homework::where(['id' => $id])->first();
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
