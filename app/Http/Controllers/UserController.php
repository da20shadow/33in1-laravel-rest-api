<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
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
            $user = null;
            if (isset($validatedData['firstName'])) {
                $user = User::where('id', $userId)
                    ->update(['first_name' => $validatedData['firstName']]);
            }
            if (isset($validatedData['lastName'])) {
                $user = User::where('id', $userId)
                    ->update(['last_name' => $validatedData['lastName']]);
            }
            if (isset($validatedData['email'])) {
                $user = User::where('id', $userId)
                    ->update(['email' => $validatedData['email']]);
            }
            if (isset($validatedData['password'])) {
                $user = User::where('id', $userId)
                    ->update(['password' => bcrypt($validatedData['password'])]);
            }
            return response()->json([
                'user' => $user,
                'message' => Messages::SUCCESS_UPDATE_PROFILE,
            ]);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage(),
            ],400);
        }
    }

    public function destroy(string $id)
    {
        //TODO: implement delete
    }
}
