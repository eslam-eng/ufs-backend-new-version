<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\ReceiverController;
use App\Http\Controllers\Api\RestPasswordController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('phone/verify', PhoneVerifyController::class);
    Route::post('password/forget', PhoneVerifyController::class);
    Route::post('password/reset', RestPasswordController::class);
});

Route::group(['prefix' => 'user','middleware' => 'auth:sanctum'], function () {
    Route::post('set-fcm-token', [AuthController::class, 'setFcmToken']);
});

Route::resource('receiver', ReceiverController::class);