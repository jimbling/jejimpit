<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Jimpitan\BkuLengkapController;

Route::middleware(['auth', 'verified', 'can:atur bku'])
    ->prefix('bku')
    ->name('bku.')
    ->group(function () {
        Route::get('/lengkap', [BkuLengkapController::class, 'index'])->name('lengkap.index');
        Route::post('/lengkap/generate', [BkuLengkapController::class, 'generate'])->name('lengkap.generate');
    });
