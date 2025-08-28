<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Modules\Warga\WargaController;

Route::prefix('induk')
    ->middleware(['auth', 'verified'])
    ->name('induk.')
    ->group(function () {

        // CRUD Warga
        Route::get('/warga', [WargaController::class, 'index'])
            ->can('atur warga')->name('warga');
        Route::post('/warga', [WargaController::class, 'store'])
            ->can('atur warga')->name('warga.store');
        Route::delete('/warga/mass-delete', [WargaController::class, 'massDelete'])
            ->can('atur warga')->name('warga.massDelete');
        Route::delete('/warga/{id}', [WargaController::class, 'destroy'])
            ->can('atur warga')->name('warga.destroy');

        // Export QR
        Route::get('/export-qr', [WargaController::class, 'export'])
            ->name('warga.qr.export');
        Route::get('/warga/{id}/qr', [WargaController::class, 'exportSingle'])
            ->name('warga.qr.single');
    });
