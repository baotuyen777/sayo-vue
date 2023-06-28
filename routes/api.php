<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\MediasController;
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
Route::resource('categories',CategoriesController::class);
Route::resource('posts',PostsController::class);
Route::resource('products',ProductsController::class);
Route::resource('roles',RolesController::class);
Route::resource('orders',OrdersController::class);
Route::resource('medias',MediasController::class);
