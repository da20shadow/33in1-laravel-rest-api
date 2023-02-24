<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        //TODO show all Running activities
    }

    public function store(Request $request)
    {
        //TODO: start new activity
    }

    public function show(string $id)
    {
        //TODO: show Running activity by id
    }

    public function update(Request $request, string $id)
    {
        //TODO: update activity (finishing it)
    }

    public function destroy(string $id)
    {
        //TODO: Delete activity
    }
}
