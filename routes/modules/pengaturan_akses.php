<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Pengaturan\AksesController;

Route::prefix('pengaturan/akses')->name('pengaturan.akses.')->group(function () {
    Route::get('edit-role/{id}', [AksesController::class, 'editRole'])
        ->can('edit peran')->name('edit-role');
    Route::get('edit-akses', [AksesController::class, 'editPermission'])
        ->can('edit hak akses')->name('edit-permission');
    Route::post('/update-permissions', [AksesController::class, 'updatePermission'])
        ->can('update hak akses')
        ->name('update-permissions');
    Route::post('update-role', [AksesController::class, 'updateRole'])
        ->can('update peran')->name('update-role');
    Route::post('reset-password/{id}', [AksesController::class, 'resetPassword'])
        ->can('reset password')->name('reset-password');
    Route::delete('hapus-akun', [AksesController::class, 'hapusAkun'])
        ->can('hapus akun')->name('hapus-akun');

    Route::post('tambah-user', [AksesController::class, 'tambahUser'])
        ->can('tambah akun')->name('tambah.user');
});
