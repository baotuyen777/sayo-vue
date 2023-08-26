<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Fe\HomeController;
use \App\Http\Controllers\Fe\AuthController;

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
Route::view("/","home");
Route::resource('/', HomeController::class);

Route::get('/cat/{slug}', [HomeController::class, 'archive']);

Route::get('/mua-ban-{catSlug}/{postId}.htm', [HomeController::class, 'postDetail']);
Route::get('/page/{slug}.htm', [HomeController::class, 'page']);

Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);

Route::view("/admin/{any}","app")->where("any",".*");

