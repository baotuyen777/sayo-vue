<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/users/create', [UserController::class, 'create']);
//Route::get('/users/{id}', [UserController::class, 'show']);
//
//Route::get('/users', [UserController::class, 'index']);
//Route::post('/users', [UserController::class, 'store']);
//Route::get('/users/{id}/edit', [UserController::class, 'edit']);
//Route::put('/users/{id}', [UserController::class, 'update']);
Route::resource('users', UserController::class);
Route::resource('settings',SettingsController::class);
