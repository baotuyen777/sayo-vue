<?php

use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\PdwsController;

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
    Route::get('/users/create', [UserController::class, 'create']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::resource('users', UserController::class);

    Route::resource('settings', SettingsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('posts', PostsController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('orders', OrdersController::class);
    Route::resource('medias', MediasController::class);
    Route::resource('pdws', PdwsController::class);

    Route::post('posts/add-media/{id}', [PostsController::class, 'addMedia']);
});


// Fake APIs
Route::get('/table/list', function () {
    $rowsNumber = mt_rand(20, 30);
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'author' => Faker::randomString(mt_rand(5, 10)),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'id' => mt_rand(100000, 100000000),
            'pageviews' => mt_rand(100, 10000),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'title' => Faker::randomString(mt_rand(20, 50)),
        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data]));
});

Route::get('/orders', function () {
    $rowsNumber = 8;
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'order_no' => 'LARAVUE' . mt_rand(1000000, 9999999),
            'price' => mt_rand(10000, 999999),
            'status' => Faker::randomInArray(['success', 'pending']),
        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data]));
});

Route::get('/articles', function () {
    $rowsNumber = 10;
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'id' => mt_rand(100, 10000),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'title' => Faker::randomString(mt_rand(20, 50)),
            'author' => Faker::randomString(mt_rand(5, 10)),
            'comment_disabled' => Faker::randomBoolean(),
            'content' => Faker::randomString(mt_rand(100, 300)),
            'content_short' => Faker::randomString(mt_rand(30, 50)),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'forecast' => mt_rand(100, 9999) / 100,
            'image_uri' => 'https://via.placeholder.com/400x300',
            'importance' => mt_rand(1, 3),
            'pageviews' => mt_rand(10000, 999999),
            'reviewer' => Faker::randomString(mt_rand(5, 10)),
            'timestamp' => Faker::randomDateTime()->getTimestamp(),
            'type' => Faker::randomInArray(['US', 'VI', 'JA']),

        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data, 'total' => mt_rand(1000, 10000)]));
});

Route::get('articles/{id}', function ($id) {
    $article = [
        'id' => $id,
        'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
        'title' => Faker::randomString(mt_rand(20, 50)),
        'author' => Faker::randomString(mt_rand(5, 10)),
        'comment_disabled' => Faker::randomBoolean(),
        'content' => Faker::randomString(mt_rand(100, 300)),
        'content_short' => Faker::randomString(mt_rand(30, 50)),
        'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
        'forecast' => mt_rand(100, 9999) / 100,
        'image_uri' => 'https://via.placeholder.com/400x300',
        'importance' => mt_rand(1, 3),
        'pageviews' => mt_rand(10000, 999999),
        'reviewer' => Faker::randomString(mt_rand(5, 10)),
        'timestamp' => Faker::randomDateTime()->getTimestamp(),
        'type' => Faker::randomInArray(['US', 'VI', 'JA']),

    ];

    return response()->json(new JsonResponse($article));
});

Route::get('articles/{id}/pageviews', function ($id) {
    $pageviews = [
        'PC' => mt_rand(10000, 999999),
        'Mobile' => mt_rand(10000, 999999),
        'iOS' => mt_rand(10000, 999999),
        'android' => mt_rand(10000, 999999),
    ];
    $data = [];
    foreach ($pageviews as $device => $pageview) {
        $data[] = [
            'key' => $device,
            'pv' => $pageview,
        ];
    }

    return response()->json(new JsonResponse(['pvData' => $data]));
});
