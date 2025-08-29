<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Laporan\LaporanController;
use App\Http\Controllers\Modules\Jimpitan\PartisipasiController;

Route::prefix('laporan')
    ->name('laporan.')
    ->middleware(['auth', 'verified', 'can:atur laporan'])
    ->group(function () {

        Route::get('/', [LaporanController::class, 'index'])->name('index');

        Route::prefix('penerimaan-mingguan')->group(function () {
            Route::get('/', [LaporanController::class, 'penerimaanMingguanPreview'])->name('penerimaan-mingguan.preview');
            Route::get('/pdf', [LaporanController::class, 'penerimaanMingguanPdf'])->name('penerimaan-mingguan.pdf');
            Route::get('/json', [LaporanController::class, 'penerimaanMingguanJson'])->name('penerimaan-mingguan.json');
            Route::get('/cetak', [LaporanController::class, 'cetakMingguan'])->name('cetak-mingguan');
        });

        Route::prefix('bku-bulanan')->group(function () {
            Route::get('/', [LaporanController::class, 'bkuBulananIndex'])->name('bku_bulanan.index');
            Route::get('/json', [LaporanController::class, 'bkuBulananJson'])->name('bku_bulanan.json');
            Route::get('/cetak', [LaporanController::class, 'bkuBulananCetak'])->name('bku_bulanan.cetak');
        });

        Route::prefix('pengeluaran')->group(function () {
            Route::get('/', [LaporanController::class, 'pengeluaran'])->name('pengeluaran');
            Route::get('/json', [LaporanController::class, 'pengeluaranJson'])->name('pengeluaran.json');
            Route::get('/cetak', [LaporanController::class, 'pengeluaranCetak'])->name('pengeluaran.cetak');
        });

        Route::prefix('partisipasi')->group(function () {
            Route::get('/', [PartisipasiController::class, 'index'])->name('partisipasi.index');
            Route::get('/warga/{id}', [PartisipasiController::class, 'showWarga'])->name('partisipasi.warga.show');
            Route::get('/warga/{id}/transaksi', [PartisipasiController::class, 'getTransaksiByDate'])->name('partisipasi.warga.transaksi');
            Route::get('/{id}/print', [PartisipasiController::class, 'print'])->name('partisipasi.print');
            Route::get('/{id}/transaksi', [PartisipasiController::class, 'getTransaksi'])->name('partisipasi.warga.transaksi.detail');
        });
    });

Route::get('/laporan/bku/json', [LaporanController::class, 'bkuBulananJson'])->name('laporan.bku.public');
