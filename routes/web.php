<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

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

    // Route::get('/laporan', [ReportController::class, 'index'])
//     ->name('reports.index');
Route::get('/tools', function () {
    return view('tools.index');
})->name('tools.index');
/*
|--------------------------------------------------------------------------
| Redirect halaman utama
|--------------------------------------------------------------------------
*/
Route::get('/', [TransactionController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Route yang harus login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
|--------------------------------------------------------------------------
| Halaman Pilihan Laporan
|--------------------------------------------------------------------------
*/

Route::get('/reports', function () {
    return view('reports.index');
})->name('reports.index');

Route::get('/report/{period}', [TransactionController::class, 'report'])
    ->name('transactions.report');


/*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */
    Route::get('/report/{period}', [TransactionController::class, 'report'])
        ->name('transactions.report');
    Route::get('/transactions/export', [TransactionController::class, 'export'])
    ->name('transactions.export');

    /*
    |--------------------------------------------------------------------------
    | Resource
    |--------------------------------------------------------------------------
    */
    Route::resource('transactions', TransactionController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('/transactions-list', function () {

    $transactions = App\Models\Transaction::with('category')
        ->latest()
        ->paginate(5);

    return view(
        'transactions.list',
        compact('transactions')
    );

})->name('transactions.list');
});
