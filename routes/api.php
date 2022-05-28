<?php

use App\Http\Controllers\register_coode;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [UsersController::class,'login']);
    Route::post('register', [UsersController::class, 'register']);
    Route::get('logout', [UsersController::class, 'logout']);
});
Route::post('/add',[UsersController::class,'addBalance']);
Route::post('/code',[register_coode::class,'create']);