<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
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

    Route::group(['prefix' => 'google/login'], function () {
        Route::get('url', [GoogleController::class, 'getAuthUrl']);
        Route::post('', [GoogleController::class, 'postLogin']);
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::middleware(['auth:api'])->group(function () {
        // Here will be authorized routes
    });
});
