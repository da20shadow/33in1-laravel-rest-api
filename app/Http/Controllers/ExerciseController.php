<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $exercises = DB::table('exercises')->get('*');
            return response()->json([
                'exercises' => $exercises
            ]);
        } catch (QueryException $queryException) {
            return response()->json([
                'message' => $queryException->getMessage()
            ],400);
        }
    }

    public function store(Request $request)
    {
        //TODO:
    }

    public function show(string $id)
    {
        //TODO
    }

    public function update(Request $request, string $id)
    {
        //TODO:
    }

    public function destroy(string $id)
    {
        //TODO:
    }
}
