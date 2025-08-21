<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use Illuminate\Http\Request;
use App\Models\TransaksiJimpitan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Jimpitan\KehadiranService;
use App\Models\User;
use App\Models\Checkin;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    protected $kehadiranService;

    public function __construct(KehadiranService $kehadiranService)
    {
        $this->kehadiranService = $kehadiranService;
    }

    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month); // default bulan ini
        $tahun = $request->input('tahun', now()->year);  // default tahun ini

        // Ambil semua petugas role "user"
        $petugasList = User::role('user')->get();

        // Ambil data checkin / transaksi per petugas sesuai filter
        $kehadiran = $petugasList->map(function ($petugas) use ($bulan, $tahun) {
            // Total transaksi dalam periode
            $totalTransaksi = TransaksiJimpitan::where('user_id', $petugas->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->count();

            // Detail checkin
            $checkins = Checkin::where('user_id', $petugas->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->orderBy('tanggal', 'asc')
                ->get()
                ->map(function ($checkin) {
                    return [
                        'tanggal' => $checkin->tanggal->format('d M Y'),
                        'jumlah_transaksi' => $checkin->jumlah_transaksi
                    ];
                });

            return [
                'petugas' => $petugas,
                'total_transaksi' => $totalTransaksi,
                'checkins' => $checkins,
            ];
        });

        return view('modules.jimpitan.kehadiran', [
            'kehadiran' => $kehadiran,
            'selected_bulan' => $bulan,
            'selected_tahun' => $tahun,
            'title' => 'Kehadiran Petugas Jimpitan',
            'breadcrumbs' => $this->kehadiranService->getBreadcrumbs(),
        ]);
    }

    public function checkin(Request $request)
    {
        $petugas = auth()->user();
        $today = now()->toDateString();

        // Cek apakah sudah check-in hari ini
        $sudahCheckin = Checkin::where('user_id', $petugas->id)
            ->whereDate('tanggal', $today)
            ->exists();

        if ($sudahCheckin) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }

        // Hitung jumlah transaksi hari ini (opsional)
        $jumlahTransaksi = $petugas->transaksiJimpitan()
            ->whereDate('tanggal', $today)
            ->count();

        // Simpan check-in
        Checkin::create([
            'user_id' => $petugas->id,
            'tanggal' => $today,
            'jumlah_transaksi' => $jumlahTransaksi,
        ]);

        return redirect()->route('petugas.home')->with('success', 'Check-in berhasil.');
    }


    public function checkinStatus()
    {
        $petugas = auth()->user();
        $today = now()->toDateString();

        $sudahCheckin = Checkin::where('user_id', $petugas->id)
            ->whereDate('tanggal', $today)
            ->exists();

        return response()->json([
            'user_id' => $petugas->id,
            'nama' => $petugas->name,
            'tanggal' => $today,
            'sudah_checkin' => $sudahCheckin,
        ]);
    }
}
