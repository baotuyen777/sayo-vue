<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Fe\HomeController;
use \App\Http\Controllers\Fe\AuthController;
use \App\Http\Controllers\Fe\PostController;

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
//Route::view("/","home")->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cat/{slug}', [HomeController::class, 'archive']);

Route::get('/mua-ban-{catSlug}/{postId}.htm', [HomeController::class, 'postDetail']);
Route::get('/page/{slug}.htm', [HomeController::class, 'page']);
Route::get('/dang-tin', [PostController::class, 'create'])->name('publicPost');
Route::post('/dang-tin', [PostController::class, 'store'])->name('publicPost');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin ');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/post/me',[PostController::class, 'me'])->name('myPost');

Route::view("/admin/{any}","app")->where("any",".*");

