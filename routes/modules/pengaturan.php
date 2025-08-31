<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Pengaturan\AksesController;
use App\Http\Controllers\Modules\Pengaturan\SistemController;
use App\Http\Controllers\Modules\Pengaturan\PembaruanController;
use App\Http\Controllers\Modules\Pengaturan\PengaturanController;
use App\Http\Controllers\Modules\Pengaturan\PemeliharaanController;

// Pengaturan
Route::prefix('pengaturan')->middleware(['auth', 'verified'])->name('pengaturan.')->group(function () {
    Route::get('/lisensi', [PengaturanController::class, 'lisensi'])->name('lisensi');

    Route::get('/sistem', [SistemController::class, 'sistem'])
        ->can('lihat sistem')->name('sistem');
    Route::put('/sistem', [SistemController::class, 'update'])
        ->can('atur sistem')->name('sistem.update');

    Route::get('/akses', [AksesController::class, 'akses'])
        ->can('lihat hak akses')->name('akses');

    Route::get('/pembaruan', [PembaruanController::class, 'pembaruan'])
        ->can('lihat pembaruan')->name('pembaruan');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [PengaturanController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PengaturanController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PengaturanController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-avatar', [PengaturanController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::get('/profile/delete-avatar', [PengaturanController::class, 'deleteAvatar'])->name('profile.delete-avatar');
});
