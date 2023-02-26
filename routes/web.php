<?php

use App\Http\Controllers\ReactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{path?}', [ReactController::class, 'index'])
    ->where('path', '.*');

//Route::any('/{any}', [ReactController::class,'index'])
//    ->where('any',"^(?!api).*$");

//Route::get('/', function () {
//    return view('welcome');
//});
