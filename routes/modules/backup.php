<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Pengaturan\PemeliharaanController;

Route::prefix('pengaturan')->middleware(['auth', 'verified'])->name('pengaturan.')->group(function () {
    Route::get('/pemeliharaan', [PemeliharaanController::class, 'index'])->name('pemeliharaan.index');
    Route::post('/backup', [PemeliharaanController::class, 'backup'])->name('pemeliharaan.backup');
    Route::get('/backups', [PemeliharaanController::class, 'listBackup'])->name('pemeliharaan.backups');
    Route::get('/backups/download/{file}', [PemeliharaanController::class, 'downloadBackup'])->name('pemeliharaan.download');
    Route::delete('/backup/delete/{file}', [PemeliharaanController::class, 'delete'])
        ->name('pemeliharaan.delete');

    Route::post('/backup/start', [PemeliharaanController::class, 'startBackup'])->name('pemeliharaan.startBackup');
    Route::get('/backup/progress', [PemeliharaanController::class, 'getBackupProgress'])->name('pemeliharaan.getBackupProgress');
});
