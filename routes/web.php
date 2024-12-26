<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\RegisterController;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Rak;
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
    return redirect('/login');
});

Route::prefix('login')->middleware('guest')->group(function () {
    Route::get('', [LoginController::class, 'index']);
    Route::post('/', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('register')->middleware('guest')->group(function () {
    Route::get('', [RegisterController::class, 'index'])->name('register');
    Route::post('', [RegisterController::class, 'store']);
});


Route::prefix('content')->middleware('auth')->group(function() {
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('pengembalian', PengembalianController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('rak', RakController::class);
    Route::resource('pengarang', PengarangController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('anggota', AnggotaController::class);
});
