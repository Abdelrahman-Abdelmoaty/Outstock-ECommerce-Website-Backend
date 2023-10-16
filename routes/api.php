<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProductController;
use Google\Service\Connectors\AuthConfig;
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


Route::group(['middleware' => 'json.response'], function () {
    Route::get('', function () {
        return '';
    })->name('password.reset');

    Route::group(['prefix' => 'google/login'], function () {
        Route::get('url', [GoogleController::class, 'getAuthUrl']);
        Route::post('', [GoogleController::class, 'postLogin']);
    });

    Route::apiResource('products', ProductController::class)->only('index', 'show');

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('forgot-password', [AuthController::class, 'forgot_password']);
        Route::post('change-password', [AuthController::class, 'change_password'])
            ->middleware('auth:sanctum');
    });
});
