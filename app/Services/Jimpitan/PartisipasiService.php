<?php

namespace App\Services\Jimpitan;

use App\Models\Warga;
use App\Helpers\BreadcrumbHelper;
use App\Models\TransaksiJimpitan;
use Illuminate\Support\Facades\DB;

class PartisipasiService
{
    /**
     * Rekap mingguan per warga
     */
    public function getMingguanPerWarga()
    {
        return TransaksiJimpitan::select(
            'warga_id',
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('WEEK(tanggal, 1) as minggu'),
            DB::raw('SUM(jumlah) as total_setor'),
            DB::raw('COUNT(*) as jumlah_transaksi')
        )
            ->groupBy('warga_id', 'tahun', 'minggu')
            ->with('warga')
            ->get();
    }

    /**
     * Rekap bulanan per warga
     */
    public function getBulananPerWarga()
    {
        return TransaksiJimpitan::select(
            'warga_id',
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(jumlah) as total_setor'),
            DB::raw('COUNT(*) as jumlah_transaksi')
        )
            ->groupBy('warga_id', 'tahun', 'bulan')
            ->with('warga')
            ->get();
    }

    /**
     * Rekap tahunan per warga
     */
    public function getTahunanPerWarga()
    {
        return TransaksiJimpitan::select(
            'warga_id',
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('SUM(jumlah) as total_setor'),
            DB::raw('COUNT(*) as jumlah_transaksi')
        )
            ->groupBy('warga_id', 'tahun')
            ->with('warga')
            ->get();
    }

    /**
     * Rekap mingguan per petugas (user)
     */
    public function getMingguanPerPetugas()
    {
        return TransaksiJimpitan::select(
            'user_id',
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('WEEK(tanggal, 1) as minggu'),
            DB::raw('SUM(jumlah) as total_dikelola'),
            DB::raw('COUNT(*) as jumlah_transaksi')
        )
            ->groupBy('user_id', 'tahun', 'minggu')
            ->with('user')
            ->get();
    }

    /**
     * Rekap bulanan per petugas
     */
    public function getBulananPerPetugas()
    {
        return TransaksiJimpitan::select(
            'user_id',
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(jumlah) as total_dikelola'),
            DB::raw('COUNT(*) as jumlah_transaksi')
        )
            ->groupBy('user_id', 'tahun', 'bulan')
            ->with('user')
            ->get();
    }

    /**
     * Rekap tahunan per petugas
     */
    public function getTahunanPerPetugas()
    {
        return TransaksiJimpitan::select(
            'user_id',
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('SUM(jumlah) as total_dikelola'),
            DB::raw('COUNT(*) as jumlah_transaksi')
        )
            ->groupBy('user_id', 'tahun')
            ->with('user')
            ->get();
    }

    public function getRekapSemuaWarga()
    {
        return Warga::withSum('transaksiJimpitan as total_setor', 'jumlah')
            ->orderBy('nama_kk')
            ->get();
    }

    public function getDetailWarga($id)
    {
        return Warga::findOrFail($id);
    }

    public function getDetailWargaWithFilter($id, $start = null, $end = null)
    {
        return Warga::with(['transaksiJimpitan' => function ($q) use ($start, $end) {
            $q->with('user')->orderBy('tanggal', 'desc');

            if ($start && $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            } else {
                // default: hanya tahun berjalan
                $q->whereYear('tanggal', now()->year);
            }
        }])->findOrFail($id);
    }


    public function getBreadcrumbs()
    {
        return BreadcrumbHelper::generate([
            ['name' => 'Data Partisipasi Warga']
        ]);
    }
}
