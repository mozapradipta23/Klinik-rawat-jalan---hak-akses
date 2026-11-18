<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dokter.index'));

// Login / logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Semua user yang sudah login boleh MELIHAT daftar dokter
Route::middleware('auth')->group(function () {
    Route::resource('dokter', DokterController::class)->only('index');
});

// Hanya admin yang boleh tambah, ubah, dan hapus
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dokter', DokterController::class)->except(['index', 'show']);
});
