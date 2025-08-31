<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PemeliharaanController extends Controller
{
    public function index()
    {
        // Ambil daftar file backup dari storage/app/public/JDashboard
        $files = Storage::disk('public')->files('JDashboard');

        $backups = collect($files)
            ->filter(fn($file) => str_ends_with($file, '.zip'))
            ->map(function ($file) {
                return [
                    'file_name' => basename($file),
                    'file_size' => Storage::disk('public')->size($file),
                    'last_modified' => \Carbon\Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file))
                        ->timezone('Asia/Jakarta')
                        ->locale('id'),
                    'path' => $file
                ];
            })
            ->sortByDesc('last_modified');


        return view('modules.admin.pengaturan-pemeliharaan', [
            'title' => 'Pemeliharaan Sistem',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pemeliharaan Sistem']
            ]),
            'user' => Auth::user(),
            'backups' => $backups,
        ]);
    }

    public function startBackup()
    {
        $logFile = storage_path('logs/backup-progress.log');


        file_put_contents($logFile, "Memulai backup sistem...\n");

        $artisan = base_path('artisan');


        $command = "php \"$artisan\" backup:run >> \"$logFile\" 2>&1";

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen("start /B $command", "r"));
        } else {
            exec("$command > /dev/null 2>&1 &");
        }

        return response()->json(['status' => 'started']);
    }


    public function getBackupProgress()
    {
        $logFile = storage_path('logs/backup-progress.log');

        if (!file_exists($logFile)) {
            return response()->json(['progress' => 'Menunggu proses backup...']);
        }

        $content = file_get_contents($logFile);


        $content = str_replace(
            [
                'Starting backup...',
                'Dumping database',
                'Determining files to backup...',
                'Zipping',
                'Created zip containing',
                'Copying zip to disk named',
                'Successfully copied zip to disk named',
                'Backup completed!'
            ],
            [
                'Memulai backup...',
                'Mencadangkan database',
                'Menentukan file-file yang akan dibackup...',
                'Mengompres file...',
                'Berhasil membuat arsip zip berisi',
                'Menyalin file zip ke storage',
                'Berhasil menyalin file zip ke storage',
                'Backup selesai!'
            ],
            $content
        );

        return response()->json(['progress' => nl2br(e($content))]);
    }



    public function downloadBackup($file)
    {
        $path = 'JDashboard/' . $file;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, "Backup tidak ditemukan.");
        }

        return Storage::disk('public')->download($path);
    }

    public function delete($file)
    {
        $file = urldecode($file);
        $filePath = "JDashboard/{$file}";

        try {
            $deleted = Storage::disk('public')->delete($filePath);

            if ($deleted) {
                return redirect()
                    ->route('pengaturan.pemeliharaan.index')
                    ->with('success', "Backup {$file} berhasil dihapus.");
            } else {
                return redirect()
                    ->route('pengaturan.pemeliharaan.index')
                    ->with('error', "Backup {$file} tidak ditemukan.");
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('pengaturan.pemeliharaan.index')
                ->with('error', "Terjadi kesalahan saat menghapus backup: " . $e->getMessage());
        }
    }
}
