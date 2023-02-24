<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function profile(): JsonResponse
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $userId = auth()->user()->getAuthIdentifier();

            if (isset($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }
            User::where('id', $userId)->update($validatedData);
            return response()->json([
                'message' => Messages::UPDATE_PROFILE_SUCCESS,
            ]);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage(),
            ],400);
        }
    }

    public function destroy(): JsonResponse
    {
        $user_id = auth()->user()->getAuthIdentifier();
        try {
            User::where('id',$user_id)
                ->delete();
        }catch (QueryException $exception){
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ],400);
        }

        return response()->json(['message' => Messages::DELETED_PROFILE_SUCCESS]);
    }
}
