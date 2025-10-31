<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Jimpitan\PenerimaanController;

Route::middleware(['auth', 'verified', 'can:atur penerimaan'])
    ->prefix('penerimaan')
    ->name('penerimaan.')
    ->group(function () {
        Route::get('/', [PenerimaanController::class, 'index'])->name('index');
        Route::post('/generate-mingguan', [PenerimaanController::class, 'generateMingguan'])->name('generate-mingguan');
        Route::post('/generate-bulanan', [PenerimaanController::class, 'generateBulanan'])->name('generate-bulanan');
        Route::post('/lock-mingguan/{id}', [PenerimaanController::class, 'lockMingguan'])->name('lock-mingguan');
        Route::post('/lock-bulanan/{id}', [PenerimaanController::class, 'lockBulanan'])->name('lock-bulanan');
        Route::delete('/hapus-mingguan/{id}', [PenerimaanController::class, 'hapusMingguan'])->name('hapus-mingguan');
        Route::delete('/hapus-bulanan/{id}', [PenerimaanController::class, 'hapusBulanan'])->name('hapus-bulanan');
    });
