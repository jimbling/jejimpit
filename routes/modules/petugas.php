<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Jimpitan\PetugasController;

Route::prefix('petugas/jimpitan')
    ->middleware(['auth', 'verified'])
    ->name('petugas.jimpitan.')
    ->group(function () {
        Route::get('/', [PetugasController::class, 'index'])->can('entri jimpitan')->name('index');
        Route::get('/create', [PetugasController::class, 'create'])->can('entri jimpitan')->name('create');
        Route::post('/store', [PetugasController::class, 'store'])->can('entri jimpitan')->name('store');

        // Route baru: riwayat transaksi jimpitan
        Route::get('/riwayat', [PetugasController::class, 'riwayat'])->can('entri jimpitan')->name('riwayat');
    });

// Tampilan khusus petugas (role user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/petugas/home', [PetugasController::class, 'index'])
        ->name('petugas.home');

    Route::get('/petugas/profile', function () {
        return view('modules.petugas.profile.edit');
    })->name('petugas.profile.edit');
});
