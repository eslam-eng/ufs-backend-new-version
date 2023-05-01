<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\ReceiverController;
use App\Http\Controllers\Api\RestPasswordController;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\CompanyController;
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
Route::group(['middleware' => 'auth:sanctum'],function (){

    Route::group(['prefix' => 'user'], function () {
        Route::post('set-fcm-token', [AuthController::class, 'setFcmToken']);
    });

    Route::group(['prefix' => 'locations'], function () {
        Route::get('governorates', [LocationsController::class, 'getAllGovernorates']);
        Route::get('{parent_id}', [LocationsController::class, 'getLocationByParentId']);
    });

    Route::resource('companies',CompanyController::class);
    Route::group(['prefix' => 'company'],function (){
        Route::get('{id}',[CompanyController::class,'getCompanyById']);
    });

    Route::apiResource('receivers', ReceiverController::class);

});
