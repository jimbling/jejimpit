<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Jimpitan\KehadiranController;
use App\Http\Controllers\Modules\Jimpitan\TransaksiJimpitanController;

// Transaksi Jimpitan
Route::prefix('transaksi')->middleware(['auth', 'verified'])->name('transaksi.')->group(function () {
    Route::get('/jimpitan', [TransaksiJimpitanController::class, 'index'])
        ->can('atur jimpitan')->name('jimpitan.index');

    Route::post('/jimpitan', [TransaksiJimpitanController::class, 'store'])
        ->can('atur jimpitan')->name('jimpitan.store');

    Route::delete('/jimpitan/{id}', [TransaksiJimpitanController::class, 'destroy'])
        ->can('atur jimpitan')->name('jimpitan.destroy');

    // Opsional: mass delete
    Route::delete('/jimpitan-mass-delete', [TransaksiJimpitanController::class, 'massDelete'])
        ->can('atur jimpitan')->name('jimpitan.massDelete');
});

Route::get('/transaksi/{id}/resend-wa', [TransaksiJimpitanController::class, 'resendWhatsapp'])
    ->middleware(['auth', 'can:atur jimpitan'])
    ->name('transaksi.resendWa');


// Transaksi Jimpitan
Route::middleware(['auth', 'verified'])->name('kehadiran.')->group(function () {
    Route::get('/kehadiran', [KehadiranController::class, 'index'])
        ->can('atur jimpitan')->name('index');
    Route::get('/kehadiran-status', [KehadiranController::class, 'checkinStatus'])
        ->name('status');
    Route::post('/kehadiran/checkin', [KehadiranController::class, 'checkin'])
        ->name('checkin');
});
