<?php

use App\Http\Controllers\Fe\OrdersController;
use App\Http\Controllers\Fe\PdwController;
use App\Http\Controllers\Fe\AuthController;
use App\Http\Controllers\Fe\CommentController;
use App\Http\Controllers\Fe\HomeController;
use App\Http\Controllers\Fe\PasswordResetController;
use App\Http\Controllers\Fe\PostController;
use App\Http\Controllers\Fe\ProductController;
use App\Http\Controllers\Fe\ReviewController;
use App\Http\Controllers\Fe\UserController;
use App\Livewire\post\PostArchiveComponent;
use App\Livewire\post\PostDetailComponent;
use App\Livewire\product\ProductDetailComponent;
use App\Livewire\Shop;
use App\Livewire\user\UserIndexComponent;
use App\Livewire\user\UserShowComponent;
use App\Livewire\user\UserEditComponent;
use App\Livewire\user\UserProfileComponent;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/test-email', [HomeController::class, 'testEmail'])->name('testEmail');
//
Route::get('/page/{code}.htm', [HomeController::class, 'page'])->name('pageView');
//
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin ');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('doRegister');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleCallback']);
Route::get('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'doForgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
Route::post('/change-password/{token}', [PasswordResetController::class, 'doResetPassword'])->name('password.doReset');
//
// User Livewire Components
Route::get('/users', UserIndexComponent::class)->name('user.index');
Route::get('/user/{userName}', UserShowComponent::class)->name('user.show');
Route::get('/user/{username}/edit', UserEditComponent::class)->name('user.edit');
Route::get('/profile', UserProfileComponent::class)->name('profile');
//
////Route::get('/post/crawl', [PostController::class, 'crawl'])->name('postCrawl');
////Route::get('/post/me', [PostController::class, 'me'])->name('myPost');
////Route::get('/post/edit/{code}.htm', [PostController::class, 'edit'])->name('postEdit');
////Route::post('/post/edit/{code}.htm', [PostController::class, 'update'])->name('postUpdate');
////Route::put('/post/update-simple/{code}.htm', [PostController::class, 'updateSimple'])->name('postUpdateSimple');
Route::get('/get-attrs/{catCode?}', [PostController::class, 'getAttrs'])->name('getPostAttrs');
Route::get('/dang-tin', [PostController::class, 'create'])->name('publicPost');
Route::post('/dang-tin', [PostController::class, 'store'])->name('storePost');
//Route::get('/mua-ban/{catCode?}/{provinceCode?}/{districtCode?}/{wardCode?}', [PostController::class, 'archive'])->name('archive');
//Route::get('/xem-tin-{catCode?}/{code?}.htm', [PostController::class, 'show'])->where('catCode', '[A-Za-z0-9-]+')->name('postView');
////Route::resource('post', PostController::class);
Route::resource('comment', CommentController::class);
//
//Route::get('/dang-san-pham', [ProductController::class, 'create'])->name('createProduct');
//Route::post('/dang-san-pham', [ProductController::class, 'store'])->name('storeProduct');
//Route::get('/product/edit/{code}.htm', [ProductController::class, 'edit'])->name('productEdit');
//Route::post('/product/edit/{code}.htm', [ProductController::class, 'update'])->name('productUpdate');
//Route::put('/product/update-simple/{code}.htm', [ProductController::class, 'updateSimple'])->name('productUpdateSimple');
//Route::get('/xem-san-pham-{catCode?}/{code}.htm', [ProductController::class, 'show'])->where('catCode', '[A-Za-z0-9-]+')->name('productView');
//Route::resource('product', ProductController::class);
//Route::resource('/review', ReviewController::class);

Route::get('getDistricts/{provinceId?}', [PdwController::class,'getDistricts'])->name('getDistricts');
Route::get('getWards/{districtId?}', [PdwController::class,'getWards'])->name('getWards');

Route::resource('order', OrdersController::class);

// Bio update route
Route::post('/user/{username}/update', [UserController::class, 'update'])->name('user.update');

//livewire
//Route::get('/posts', PostArchiveComponent::class);
Route::get('/mua-ban/{catCode?}/{provinceCode?}/{districtCode?}/{wardCode?}', PostArchiveComponent::class)->name('archive');
//Route::get('/post/{code}', PostDetail::class)->name('post.detail');
Route::get('/xem-tin-{catCode?}/{code?}.htm', PostDetailComponent::class)->where('catCode', '[A-Za-z0-9-]+')->name('postView');
Route::get('/xem-san-pham-{catCode?}/{code}.htm', ProductDetailComponent::class)->where('catCode', '[A-Za-z0-9-]+')->name('productView');
Route::get('shop/{code}', Shop::class)->name('shop');
//Route::get('/users', UserComponent::class);
//Route::get('/products', ProductComponent::class);
