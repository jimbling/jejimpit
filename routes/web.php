<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));
Route::get('/dashboard', [App\Http\Controllers\Modules\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/clear-session-flash', function (Illuminate\Http\Request $request) {
    foreach ($request->keys as $key) {
        session()->forget($key);
    }
    return response()->json(['status' => 'success']);
})->name('clear.session.flash');

// Require route modul
require __DIR__ . '/auth.php';
require __DIR__ . '/modules/dashboard.php';
require __DIR__ . '/modules/pengaturan.php';
require __DIR__ . '/modules/pengaturan_akses.php';
require __DIR__ . '/modules/warga.php';
require __DIR__ . '/modules/jimpitan.php';
require __DIR__ . '/modules/penerimaan.php';
require __DIR__ . '/modules/pengeluaran.php';
require __DIR__ . '/modules/bku.php';
require __DIR__ . '/modules/laporan.php';
require __DIR__ . '/modules/gdrive.php';
require __DIR__ . '/modules/petugas.php';
