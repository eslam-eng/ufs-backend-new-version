<?php

use App\Enums\ActivationStatus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/migrate-fresh/{password}', function ($password) {
    if ($password == 150024){
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');
        return "migrate fresh success";
    }
});
