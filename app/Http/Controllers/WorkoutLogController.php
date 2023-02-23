<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutLogController extends Controller
{
    public function index()
    {
        //Get Last 30 days workout logs
    }

    public function store(Request $request)
    {
        //Add new workout log
    }

    public function show(string $id)
    {
        //show workout log by id
    }

    public function update(Request $request, string $id)
    {
        //Updated workout log
    }
}
