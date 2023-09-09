<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Fe\HomeController;
use \App\Http\Controllers\Fe\AuthController;
use \App\Http\Controllers\Fe\PostController;
use \App\Http\Controllers\Fe\UserController;

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




Route::get('/page/{code}.htm', [HomeController::class, 'page'])->name('pageView');


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin ');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('doRegister');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/post/me', [PostController::class, 'me'])->name('myPost');
Route::get('/post/edit/{slug}.htm', [PostController::class, 'show'])->name('postEdit');
Route::post('/post/edit/{slug}.htm', [PostController::class, 'update'])->name('postUpdate');
Route::get('/dang-tin', [PostController::class, 'create'])->name('publicPost');
Route::post('/dang-tin', [PostController::class, 'store'])->name('storePost');

//Route::get('/cat/{slug}', [HomeController::class, 'archive']);

//Route::get('/mua-ban-{catCode?}-{provinceCode?}-{districtCode?}-{wardCode?}', [HomeController::class, 'archive'])->name('archiveWard');
//Route::get('/mua-ban-{catCode?}-{provinceCode?}-{districtCode?}', [HomeController::class, 'archive'])->name('archiveDistrict');
Route::get('/mua-ban-{catCode?}-{provinceCode?}', [HomeController::class, 'archive'])->name('archiveProvince');
Route::get('/mua-ban-{catCode?}', [HomeController::class, 'archive'])->name('archive');




Route::get('/xem-tin-{catSlug}/{slug}.htm', [PostController::class, 'postDetail'])->where('catSlug', '[A-Za-z0-9-]+')->name('postView');

Route::resource('user', UserController::class);
Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::view("/admin/{any}", "app")->where("any", ".*");

