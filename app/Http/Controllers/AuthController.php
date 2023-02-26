<?php

namespace App\Http\Controllers;

use App\Constants\AppMessages\Messages;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        // Attempt to log the user in
        if (auth()->attempt($request->only('email', 'password'))) {
            // If login succeeds
            $user = User::where('email', $request['email'])->first();
            $token = $user->createToken('33in1AppAuthAccessToken')->plainTextToken;
            return response()->json([
                'message' => Messages::LOGIN_SUCCESS,
                'token' => $token,
            ]);
        } else {
            // If login fails, redirect the user back to the login form with error message
            return response()->json([
                'message' => Messages::BAD_CREDENTIALS
            ], 400);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            if ($this->userExist($validatedData['email'])) {
                return response()->json([
                    'message' => Messages::EMAIL_EXIST,
                ], 400);
            }

            $user = User::create([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);
            return response()->json([
                'message' => Messages::REGISTER_SUCCESS,
                'user' => $user
            ], 201);
        } catch (QueryException $exception) {
            return response()->json([
                'message' => Messages::DEFAULT_ERROR_MESSAGE,
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    public function logout(): JsonResponse
    {
        $userId = auth()->user()->getAuthIdentifier();
        if (!$userId) {
            return response()->json(['message' => 'Already logged out!']);
        }
        auth()->user()->tokens()->delete();
        return response()->json(['message' => Messages::LOGOUT_SUCCESS]);
    }

    private function userExist(string $email): bool
    {
        $user = User::where('email',$email)->first();
        if ($user) {
            return true;
        }
        return false;
    }


}
