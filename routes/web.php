<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Redirect halaman utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()->route('transactions.index');

});

/*
|--------------------------------------------------------------------------
| Route yang harus login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */
    Route::get('/report/{period}', [TransactionController::class, 'report'])
        ->name('transactions.report');

    /*
    |--------------------------------------------------------------------------
    | Resource
    |--------------------------------------------------------------------------
    */
    Route::resource('transactions', TransactionController::class);

    Route::resource('categories', CategoryController::class);

});