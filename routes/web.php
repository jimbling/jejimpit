<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Warga\WargaController;
use App\Http\Controllers\Modules\Jimpitan\BkuController;
use App\Http\Controllers\Modules\Admin\DashboardController;
use App\Http\Controllers\Modules\Laporan\LaporanController;
use App\Http\Controllers\Modules\Jimpitan\PetugasController;
use App\Http\Controllers\Modules\Pengaturan\AksesController;
use App\Http\Controllers\Modules\Pengaturan\SistemController;
use App\Http\Controllers\Modules\Jimpitan\KehadiranController;
use App\Http\Controllers\Modules\Jimpitan\BkuLengkapController;
use App\Http\Controllers\Modules\Jimpitan\PenerimaanController;
use App\Http\Controllers\Modules\Jimpitan\PartisipasiController;
use App\Http\Controllers\Modules\Jimpitan\PengeluaranController;
use App\Http\Controllers\Modules\Pengaturan\PembaruanController;
use App\Http\Controllers\Modules\Pengaturan\PengaturanController;
use App\Http\Controllers\Modules\Pengaturan\GoogleDriveController;
use App\Http\Controllers\Modules\Pengaturan\PemeliharaanController;
use App\Http\Controllers\Modules\Jimpitan\TransaksiJimpitanController;
use App\Http\Controllers\PartisipasiController as ControllersPartisipasiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Pengaturan
Route::prefix('pengaturan')->middleware(['auth', 'verified'])->name('pengaturan.')->group(function () {
    Route::get('/lisensi', [PengaturanController::class, 'lisensi'])->name('lisensi');

    Route::get('/sistem', [SistemController::class, 'sistem'])
        ->can('lihat sistem')->name('sistem');
    Route::put('/sistem', [SistemController::class, 'update'])
        ->can('atur sistem')->name('sistem.update');

    Route::get('/akses', [AksesController::class, 'akses'])
        ->can('lihat hak akses')->name('akses');

    Route::get('/pembaruan', [PembaruanController::class, 'pembaruan'])
        ->can('lihat pembaruan')->name('pembaruan');

    Route::get('/pemeliharaan', [PemeliharaanController::class, 'pemeliharaan'])
        ->can('lihat pemeliharaan')->name('pemeliharaan');
});

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



// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [PengaturanController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PengaturanController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PengaturanController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-avatar', [PengaturanController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::get('/profile/delete-avatar', [PengaturanController::class, 'deleteAvatar'])->name('profile.delete-avatar');
});



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




Route::post('/clear-session-flash', function (Illuminate\Http\Request $request) {
    foreach ($request->keys as $key) {
        session()->forget($key);
    }
    return response()->json(['status' => 'success']);
})->name('clear.session.flash');


// Induk Warga
Route::prefix('induk')->middleware(['auth', 'verified'])->name('induk.')->group(function () {
    Route::get('/warga', [WargaController::class, 'index'])
        ->can('atur warga')->name('warga');
    Route::delete('/warga/mass-delete', [WargaController::class, 'massDelete'])->can('atur warga')->name('warga.massDelete');
    Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->can('atur warga')->name('warga.destroy');
    Route::post('/warga', [WargaController::class, 'store'])->can('atur warga')->name('warga.store');
});

Route::get('/export-qr', [WargaController::class, 'export'])->name('warga.qr.export');
Route::get('/warga/{id}/qr', [WargaController::class, 'exportSingle'])->name('induk.warga.qr');


// Transaksi Jimpitan
Route::prefix('transaksi')->middleware(['auth', 'verified'])->name('transaksi.')->group(function () {
    Route::get('/jimpitan', [TransaksiJimpitanController::class, 'index'])
        ->can('atur jimpitan')->name('jimpitan.index');

    Route::post('/jimpitan', [TransaksiJimpitanController::class, 'store'])
        ->can('atur jimpitan')->name('jimpitan.store');

    Route::delete('/jimpitan/{id}', [TransaksiJimpitanController::class, 'destroy'])
        ->can('atur jimpitan')->name('jimpitan.destroy');

    // Opsional: mass delete
    Route::delete('/jimpitan-mass-delete', [TransaksiJimpitanController::class, 'massDelete'])
        ->can('atur jimpitan')->name('jimpitan.massDelete');
});

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


// Transaksi Jimpitan
Route::middleware(['auth', 'verified'])->name('kehadiran.')->group(function () {
    Route::get('/kehadiran', [KehadiranController::class, 'index'])
        ->can('atur jimpitan')->name('index');
    Route::get('/kehadiran-status', [KehadiranController::class, 'checkinStatus'])
        ->name('status');
    Route::post('/kehadiran/checkin', [KehadiranController::class, 'checkin'])
        ->name('checkin');
});



// Tampilan khusus petugas (role user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/petugas/home', [PetugasController::class, 'index'])
        ->name('petugas.home');

    Route::get('/petugas/profile', function () {
        return view('modules.petugas.profile.edit');
    })->name('petugas.profile.edit');
});

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

Route::middleware(['auth', 'verified', 'can:atur pengeluaran'])->group(function () {
    Route::resource('pengeluaran', PengeluaranController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/pengeluaran/get-saldo', [PengeluaranController::class, 'getSaldo'])
        ->name('pengeluaran.getSaldo');
});

Route::middleware(['auth', 'verified', 'can:atur bku'])
    ->prefix('bku')
    ->name('bku.')
    ->group(function () {
        Route::get('/lengkap', [BkuLengkapController::class, 'index'])->name('lengkap.index');
        Route::post('/lengkap/generate', [BkuLengkapController::class, 'generate'])->name('lengkap.generate');
    });

Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::get('penerimaan-mingguan', [LaporanController::class, 'penerimaanMingguanPreview'])->name('penerimaan-mingguan.preview');
    Route::get('penerimaan-mingguan/pdf', [LaporanController::class, 'penerimaanMingguanPdf'])->name('penerimaan-mingguan.pdf');
    Route::get('penerimaan-mingguan/json', [LaporanController::class, 'penerimaanMingguanJson'])->name('penerimaan-mingguan.json');
    Route::get('/penerimaan-mingguan/cetak', [LaporanController::class, 'cetakMingguan'])->name('laporan.cetak-mingguan');
});

Route::prefix('laporan')->group(function () {
    Route::get('/bku-bulanan', [LaporanController::class, 'bkuBulananIndex'])->name('laporan.bku_bulanan.index');
    Route::get('/bku-bulanan/json', [LaporanController::class, 'bkuBulananJson'])->name('laporan.bku_bulanan.json');
    Route::get('/bku-bulanan/cetak', [LaporanController::class, 'bkuBulananCetak'])->name('laporan.bku_bulanan.cetak');
});

Route::prefix('laporan')->group(function () {
    Route::get('/pengeluaran', [LaporanController::class, 'pengeluaran'])->name('laporan.pengeluaran');
    Route::get('/pengeluaran/json', [LaporanController::class, 'pengeluaranJson'])->name('laporan.pengeluaran.json');
    Route::get('/pengeluaran/cetak', [LaporanController::class, 'pengeluaranCetak'])->name('laporan.pengeluaran.cetak');
});

Route::prefix('laporan')->middleware(['auth'])->group(function () {
    Route::get('partisipasi', [PartisipasiController::class, 'index'])
        ->name('laporan.partisipasi.index');

    Route::get('/partisipasi/warga/{id}', [PartisipasiController::class, 'showWarga'])
        ->name('laporan.partisipasi.warga.show');

    Route::get(
        '/partisipasi/warga/{id}/transaksi',
        [PartisipasiController::class, 'getTransaksiByDate']
    )->name('laporan.partisipasi.warga.transaksi');
    Route::get('/partisipasi/{id}/print', [PartisipasiController::class, 'print'])->name('partisipasi.print');
    Route::get('/partisipasi/{id}/transaksi', [PartisipasiController::class, 'getTransaksi'])
        ->name('laporan.partisipasi.warga.transaksi');
});




require __DIR__ . '/auth.php';
