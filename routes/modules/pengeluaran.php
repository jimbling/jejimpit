<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Jimpitan\PengeluaranController;

Route::middleware(['auth', 'verified', 'can:atur pengeluaran'])->group(function () {
    Route::resource('pengeluaran', PengeluaranController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/pengeluaran/get-saldo', [PengeluaranController::class, 'getSaldo'])
        ->name('pengeluaran.getSaldo');
});
