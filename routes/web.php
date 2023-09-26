<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Fe\HomeController;
use \App\Http\Controllers\Fe\AuthController;
use \App\Http\Controllers\Fe\PostController;
use \App\Http\Controllers\Fe\UserController;
use \App\Http\Controllers\Fe\PdwController;
use Illuminate\Support\Facades\Artisan;
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

Route::resource('user', UserController::class);
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/user/update-simple/{username}.htm', [UserController::class, 'updateSimple'])->name('userUpdateSimple');

Route::resource('post', PostController::class);
Route::get('/post/me', [PostController::class, 'me'])->name('myPost');
Route::get('/post/edit/{slug}.htm', [PostController::class, 'edit'])->name('postEdit');
Route::post('/post/edit/{slug}.htm', [PostController::class, 'update'])->name('postUpdate');
Route::post('/post/update-simple/{slug}.htm', [PostController::class, 'updateSimple'])->name('postUpdateSimple');
Route::get('/dang-tin', [PostController::class, 'create'])->name('publicPost');
Route::post('/dang-tin', [PostController::class, 'store'])->name('storePost');
Route::get('/mua-ban/{catCode?}/{provinceCode?}/{districtCode?}/{wardCode?}', [PostController::class, 'archive'])->name('archive');
Route::get('/xem-tin-{catSlug?}/{slug}.htm', [PostController::class, 'show'])->where('catSlug', '[A-Za-z0-9-]+')->name('postView');



Route::get('/get-districts/{provinceId?}', [PdwController::class, 'getDistricts'])->name('getDistricts');
Route::get('/get-wards/{districtId?}', [PdwController::class, 'getWards'])->name('getWards');


Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return view('pages/auth/login');
});

Route::view("/admin/{any}", "app")->where("any", ".*");

