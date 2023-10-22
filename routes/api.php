<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacebookController;
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


Route::get('', function () {
    return '';
})->name('password.reset');


Route::apiResource('products', ProductController::class)->only('index', 'show', 'store');

// Will be moved to auth
Route::apiResource('products', ProductController::class)->only('store', 'destroy',);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('forgot-password', [AuthController::class, 'forgot_password']);
    Route::post('change-password', [AuthController::class, 'change_password'])
        ->middleware('auth:sanctum');

    // Google Auth
    Route::group(['prefix' => 'google/login'], function () {
        Route::get('url', [GoogleController::class, 'getAuthUrl']);
        Route::post('', [GoogleController::class, 'postLogin']);
    });

    // Facebook Auth
    Route::group(['prefix' => 'facebook'], function () {
        Route::get('', [FacebookController::class, 'facebookRedirect']);
        Route::get('callback', [FacebookController::class, 'loginWithFacebook']);
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('auth/user-data', [AuthController::class, 'user_data']);
});
