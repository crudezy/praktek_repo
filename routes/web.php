<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/landing', [AuthController::class, 'showLanding'])->name('landing');

Route::get('/coa', [App\Http\Controllers\CoaController::class, 'index']);

// login customer   
Route::get('/depan', [App\Http\Controllers\KeranjangController::class, 'daftarlayanan'])
     ->middleware('customer')
     ->name('depan');
Route::get('/login', function () {
    return view('login');
});

// tambah keranjang
Route::post('/tambah', [App\Http\Controllers\KeranjangController::class, 'tambahKeranjang'])->middleware(\App\Http\Middleware\CustomerMiddleware::class);
Route::get('/lihatkeranjang', [App\Http\Controllers\KeranjangController::class, 'lihatkeranjang'])->middleware(\App\Http\Middleware\CustomerMiddleware::class);

Route::delete('/hapus/{id_layanan}', [App\Http\Controllers\KeranjangController::class, 'hapus'])
    ->middleware('auth')
    ->name('hapusKeranjang');
Route::get('/lihatriwayat', [App\Http\Controllers\KeranjangController::class, 'lihatriwayat'])->middleware(\App\Http\Middleware\CustomerMiddleware::class);
// untuk autorefresh
Route::get('/cek_status_pembayaran_pg', [App\Http\Controllers\KeranjangController::class, 'cek_status_pembayaran_pg']);

// tambahan route untuk proses login
use Illuminate\Http\Request;
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/landing');
})->name('logout');

// untuk ubah password
Route::get('/ubahpassword', [App\Http\Controllers\AuthController::class, 'ubahpassword'])
    ->middleware('customer')
    ->name('ubahpassword');
Route::post('/prosesubahpassword', [App\Http\Controllers\AuthController::class, 'prosesubahpassword'])
    ->middleware('customer');

use App\Http\Controllers\JabatanController;
Route::resource('jabatan', JabatanController::class);
// prosesubahpassword


// untuk contoh perusahaan
use App\Http\Controllers\PerusahaanController;
Route::resource('perusahaan', PerusahaanController::class);
Route::get('/perusahaan/destroy/{id}', [PerusahaanController::class,'destroy']);

// contoh sampel midtrans
use App\Http\Controllers\CobaMidtransController;
Route::get('/cekmidtrans', [CobaMidtransController::class, 'cekmidtrans']);

