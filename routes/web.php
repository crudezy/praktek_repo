<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    // diarahkan ke login customer
    return view('login');
});

// Rute untuk menampilkan daftar layanan
Route::get('/depan', [App\Http\Controllers\KeranjangController::class, 'daftarLayanan'])
    ->middleware(\App\Http\Middleware\CustomerMiddleware::class)
    ->name('depan');

// Rute untuk halaman login
Route::get('/login', function () {
    return view('login');
});

// Tambahan rute untuk proses login
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

// Rute untuk logout
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Rute untuk ubah password
Route::get('/ubahpassword', [App\Http\Controllers\AuthController::class, 'ubahpassword'])
    ->middleware('customer')
    ->name('ubahpassword');
Route::post('/prosesubahpassword', [App\Http\Controllers\AuthController::class, 'prosesubahpassword'])
    ->middleware('customer');