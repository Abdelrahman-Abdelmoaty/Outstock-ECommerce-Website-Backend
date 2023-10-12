<?php

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

Route::group(['prefix' => 'google/login'], function () {
    Route::get('url', [GoogleController::class, 'getAuthUrl']);
    Route::post('', [GoogleController::class, 'postLogin']);
});

Route::middleware(['auth:api'])->group(function () {
    // Here will be authorized routes
});
