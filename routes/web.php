<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwbController;
use App\Http\Livewire\Emptypage;
use \App\Http\Livewire\Switcherpage;
use App\Http\Controllers\ReceiverController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'authentication','middleware' => 'guest'],function (){
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('singin',[AuthController::class, 'login'])->name('singin');
});

Route::get('/', function () {
    return view('livewire.index');
})->name('home')->middleware('auth');
//auth routes
Route::group(['prefix' => 'dashboard','middleware' => 'auth'],function (){
    Route::get('/', function () {
        return view('livewire.index');
    })->name('home');

    Route::group(['prefix'=>'search'],function (){
        Route::get('receivers',[ReceiverController::class,'search'])->name('receivers.search');
    });
    Route::resource('receivers',ReceiverController::class);
    Route::group(['prefix' => 'addresses' ],function (){
        Route::get('{id}/type/{type}',[AddressController::class,'create'])->name('addresses.create');
        Route::get('{id}/set-default',[AddressController::class,'create'])->name('addresses.set-default');
        Route::get('{id}/edit',[AddressController::class,'edit'])->name('address.edit');
        Route::put('{id}',[AddressController::class,'update'])->name('address.update');
    });
    Route::group(['prefix' => 'awbs' ],function (){
        Route::get('/',[AwbController::class,'index'])->name('awb.index');
        Route::get('/create',[AwbController::class,'create'])->name('awb.create');
        Route::get('/imports',[AwbController::class,'importForm'])->name('awb.import-form');
        Route::get('/download-template',[AwbController::class,'importForm'])->name('awb.download-template');
        Route::post('/',[AwbController::class,'store'])->name('awb.store');
        Route::delete('/delete',[AwbController::class,'destroy'])->name('awb.destroy');
    });

    Route::get('switcherpage', Switcherpage::class)->name('switcherpage');
});

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');
Route::get('/migrate-fresh/{password}', function ($password) {
    if ($password == 150024){

        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');
        return "migrate fresh success";
    }
})->name('clear.cache');


