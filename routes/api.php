<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\ReceiverController;
use App\Http\Controllers\Api\RestPasswordController;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DepartmentController;
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
        Route::get('cities', [LocationsController::class, 'getAllCities']);
        Route::get('areas', [LocationsController::class, 'getAllAreas']);
        Route::get('{parent_id}', [LocationsController::class, 'getLocationByParentId']);
    });

    Route::resource('companies',CompanyController::class);

    Route::resource('receivers', ReceiverController::class);

    Route::resource('addresses', AddressController::class);

    Route::resource('branches', BranchController::class);

});
    Route::apiResource('branches', BranchController::class);
    Route::apiResource('departments', DepartmentController::class);

});

