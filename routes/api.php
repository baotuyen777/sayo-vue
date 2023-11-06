<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PdwsController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
//    Route::get('/users1', [UserController::class, 'index']);
    Route::get('/logout',[AuthController::class, 'logout']);
//    Route::get('/users/create', [UserController::class, 'create']);
//    Route::get('/users/{id}', [UserController::class, 'show']);

//    Route::get('/users', [UserController::class, 'index']);
//    Route::post('/users', [UserController::class, 'store']);
//    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
//    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::resource('users', UserController::class);

    Route::resource('settings', SettingsController::class);
    Route::resource('categories', CategoriesController::class);

    Route::resource('products', ProductsController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('orders', OrdersController::class);
    Route::resource('files', FileController::class);
    Route::resource('pdws', PdwsController::class);
    Route::resource('posts', PostsController::class);
    Route::post('posts/add-media/{id}', [PostsController::class, 'addMedia']);
});


