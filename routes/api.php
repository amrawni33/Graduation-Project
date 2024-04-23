<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Front\CategoryController;
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

Route::get('/auth/login', [UserController::class, 'login']);
Route::get('/auth/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/logout/{user}', [UserController::class, 'logout']);
    Route::get('/auth/update', [UserController::class, 'update']);

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });
});
