<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Pengaturan\GoogleDriveController;


// Route grup untuk pengaturan Google Drive (butuh login & izin)
Route::prefix('pengaturan/gdrive')
    ->middleware(['auth', 'can:atur gdrive'])
    ->name('google.drive.')
    ->group(function () {
        Route::get('/', [GoogleDriveController::class, 'index'])->name('index');

        Route::post('/revoke', [GoogleDriveController::class, 'revokeAccess'])->name('revoke');

        Route::get('/upload', function () {
            return view('google_drive_upload');
        })->name('upload.view');
    });

// 👇 Callback harus di luar middleware `auth`
Route::get('/pengaturan/gdrive/callback', [GoogleDriveController::class, 'handleCallback'])
    ->name('google.drive.callback');
