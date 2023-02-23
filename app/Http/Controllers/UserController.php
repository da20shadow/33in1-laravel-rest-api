<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(): JsonResponse
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {
        //TODO: implement update
    }

    public function destroy(string $id)
    {
        //TODO: implement delete
    }
}
