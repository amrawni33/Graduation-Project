<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Front\BrandController;
use App\Http\Controllers\Api\Front\CategoryController;
use App\Http\Controllers\Api\Front\FavouriteController;
use App\Http\Controllers\Api\Front\ProductController;
use App\Http\Controllers\Api\Front\RecentController;
use App\Http\Controllers\Api\Front\WebsiteController;
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

Route::group(['middleware' => ['web']], function () {
    Route::get('/auth/google', [UserController::class, 'redireToGoogle']);
    Route::get('/auth/google-response', [UserController::class, 'handleGoogleCallback']);
});

Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/auth/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout/{user}', [UserController::class, 'logout']);
    Route::put('/auth/update', [UserController::class, 'update']);

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('brand')->group(function () {
        Route::get('/', [BrandController::class, 'index']);
        Route::get('/{brand}', [BrandController::class, 'show']);
        Route::post('/', [BrandController::class, 'store']);
        Route::put('/{brand}', [BrandController::class, 'update']);
        Route::delete('/{brand}', [BrandController::class, 'destroy']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{product}', [ProductController::class, 'show']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{product}', [ProductController::class, 'update']);
        Route::delete('/{product}', [ProductController::class, 'destroy']);
        Route::post('/', [ProductController::class, 'checkOrCreateProduct']);
    });

    Route::prefix('recent')->group(function () {
        Route::get('/', [RecentController::class, 'index']);
        Route::get('/{recent}', [RecentController::class, 'show']);
        Route::post('/', [RecentController::class, 'store']);
        Route::put('/{recent}', [RecentController::class, 'update']);
        Route::delete('/{recent}', [RecentController::class, 'destroy']);
    });

    Route::prefix('reviews')->group(function () {
        Route::get('/', [RecentController::class, 'index']);
        Route::get('/{reviews}', [RecentController::class, 'show']);
        Route::post('/', [RecentController::class, 'store']);
        Route::put('/{reviews}', [RecentController::class, 'update']);
        Route::delete('/{reviews}', [RecentController::class, 'destroy']);
    });

    Route::prefix('favourites')->group(function () {
        Route::get('/', [FavouriteController::class, 'index']);
        Route::get('/{favourite}', [FavouriteController::class, 'show']);
        Route::post('/', [FavouriteController::class, 'store']);
        Route::put('/{favourite}', [FavouriteController::class, 'update']);
        Route::delete('/{favourite}', [FavouriteController::class, 'destroy']);
    });

    Route::prefix('websites')->group(function () {
        Route::get('/', [WebsiteController::class, 'index']);
        Route::get('/{website}', [WebsiteController::class, 'show']);
        Route::post('/', [WebsiteController::class, 'store']);
        Route::put('/{website}', [WebsiteController::class, 'update']);
        Route::delete('/{website}', [WebsiteController::class, 'destroy']);
    });
});
