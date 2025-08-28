<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warga;
use App\Models\TransaksiJimpitan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $tahunIni = $now->year;
        $bulanIni = $now->month;

        // Total dana tahun ini
        $totalDana = TransaksiJimpitan::whereYear('tanggal', $tahunIni)->sum('jumlah') ?? 0;

        // Jumlah transaksi tahun ini
        $jumlahTransaksi = TransaksiJimpitan::whereYear('tanggal', $tahunIni)->count() ?? 0;

        // Target dana tahunan
        $targetDana = 11000000;
        $persenTarget = $targetDana > 0 ? round(($totalDana / $targetDana) * 100, 2) : 0;

        // Rata-rata bulan ini dan bulan lalu
        $rataBulanIni = TransaksiJimpitan::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->avg('jumlah') ?? 0;

        $bulanLalu = $now->copy()->subMonth();
        $rataBulanLalu = TransaksiJimpitan::whereMonth('tanggal', $bulanLalu->month)
            ->whereYear('tanggal', $bulanLalu->year)
            ->avg('jumlah') ?? 0;

        $selisih = $rataBulanIni - $rataBulanLalu;
        $persenKenaikan = $rataBulanLalu > 0 ? round((($rataBulanIni - $rataBulanLalu) / $rataBulanLalu) * 100, 2) : 0;

        // Partisipasi warga
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $malamMinggu = [];
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if ($date->dayOfWeek === Carbon::SATURDAY) {
                $malamMinggu[] = $date->toDateString();
            }
        }

        $jumlahMalamMinggu = count($malamMinggu);

        $jumlahPartisipan = TransaksiJimpitan::whereIn('tanggal', $malamMinggu)
            ->select('warga_id')
            ->groupBy('warga_id')
            ->havingRaw('COUNT(DISTINCT tanggal) = ?', [$jumlahMalamMinggu])
            ->get()
            ->count() ?? 0;

        $totalWarga = Warga::count() ?? 0;
        $persenPartisipasi = $totalWarga > 0 ? round(($jumlahPartisipan / $totalWarga) * 100, 2) : 0;

        // Top Warga
        $topWarga = TransaksiJimpitan::selectRaw('warga_id, COUNT(*) as total_transaksi')
            ->whereYear('tanggal', $tahunIni)
            ->groupBy('warga_id')
            ->orderByDesc('total_transaksi')
            ->with(['warga' => function ($query) use ($tahunIni) {
                $query->with(['transaksiJimpitan' => function ($q) use ($tahunIni) {
                    $q->whereYear('tanggal', $tahunIni);
                }]);
            }])
            ->limit(10)
            ->get();

        // Top Petugas
        $topPetugas = TransaksiJimpitan::selectRaw('user_id, COUNT(*) as total_transaksi')
            ->whereYear('tanggal', $tahunIni)
            ->groupBy('user_id')
            ->orderByDesc('total_transaksi')
            ->with('user')
            ->limit(3)
            ->get() ?? collect();

        // Warga dengan partisipasi rendah
        $wargaRendah = DB::table('warga')
            ->leftJoin('transaksi_jimpitan', function ($join) use ($tahunIni) {
                $join->on('warga.id', '=', 'transaksi_jimpitan.warga_id')
                    ->whereYear('transaksi_jimpitan.tanggal', $tahunIni);
            })
            ->select('warga.id', 'warga.nama_kk as nama', DB::raw('COUNT(transaksi_jimpitan.id) as total_transaksi'))
            ->groupBy('warga.id', 'warga.nama_kk')
            ->orderBy('total_transaksi', 'asc')
            ->limit(5)
            ->get() ?? collect();

        return view('welcome', compact(
            'totalDana',
            'jumlahTransaksi',
            'targetDana',
            'persenTarget',
            'rataBulanIni',
            'rataBulanLalu',
            'selisih',
            'persenKenaikan',
            'jumlahPartisipan',
            'totalWarga',
            'persenPartisipasi',
            'topWarga',
            'topPetugas',
            'wargaRendah'
        ));
    }
}
