<?php

namespace App\Http\Controllers\Modules\Laporan;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\BkuLengkap;
use Illuminate\Http\Request;
use App\Models\TransaksiJimpitan;
use App\Models\PenerimaanMingguan;

// Jika pakai barryvdh/laravel-dompdf:
use Illuminate\Support\Collection;
use App\Models\KategoriPengeluaran;
use App\Http\Controllers\Controller;
use App\Models\PengeluaranJimpitan;

class LaporanController extends Controller
{

    public function index(Request $request)
    {
        // default bulan & tahun
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // ambil daftar kategori pengeluaran untuk partial filter
        // ganti orderBy('nama') sesuai kolom nama di tabel kategori kamu
        $kategori = KategoriPengeluaran::orderBy('nama')->get();

        return view('modules.cetak.laporan-index', compact('bulan', 'tahun', 'kategori'));
    }

    public function penerimaanMingguanPreview(Request $request)
    {
        [$bulan, $tahun] = $this->resolvePeriode($request);

        $weeks = $this->buildWeeksForMonth($bulan, $tahun);
        $data = $this->computeWeeklyTotals($weeks, $bulan, $tahun);

        $totalBulan = collect($data)->sum('total');
        $forPdf = false;

        return view('laporan.penerimaan_mingguan', compact('data', 'bulan', 'tahun', 'totalBulan', 'forPdf'));
    }

    public function penerimaanMingguanPdf(Request $request)
    {
        [$bulan, $tahun] = $this->resolvePeriode($request);

        $weeks = $this->buildWeeksForMonth($bulan, $tahun);
        $data = $this->computeWeeklyTotals($weeks, $bulan, $tahun);

        $totalBulan = collect($data)->sum('total');
        $forPdf = true;

        $pdf = Mpdf::loadView('laporan.penerimaan_mingguan', compact('data', 'bulan', 'tahun', 'totalBulan', 'forPdf'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("laporan_penerimaan_mingguan_{$bulan}_{$tahun}.pdf");
    }

    public function penerimaanMingguanJson(Request $request)
    {
        [$bulan, $tahun] = $this->resolvePeriode($request);

        $weeks = $this->buildWeeksForMonth($bulan, $tahun);
        $data = $this->computeWeeklyTotals($weeks, $bulan, $tahun);

        return response()->json([
            'bulan' => (int) $bulan,
            'tahun' => (int) $tahun,
            'items' => array_values($data),
            'total_bulan' => collect($data)->sum('total'),
        ]);
    }

    /** ===================== Helpers ===================== */

    private function resolvePeriode(Request $request): array
    {
        $bulan = (int) ($request->input('bulan') ?: now()->month);
        $tahun = (int) ($request->input('tahun') ?: now()->year);
        return [$bulan, $tahun];
    }

    /**
     * Bangun rentang minggu 7-hari dari awal bulan sampai akhir bulan.
     * Contoh: 1–7, 8–14, 15–21, 22–28, 29–akhir.
     */
    private function buildWeeksForMonth(int $bulan, int $tahun): array
    {
        $start = Carbon::create($tahun, $bulan, 1)->startOfDay();
        $end   = $start->copy()->endOfMonth()->endOfDay();

        $weeks = [];
        $cursor = $start->copy();
        $i = 1;

        while ($cursor->lte($end)) {
            $from = $cursor->copy();
            $to = $cursor->copy()->addDays(6);
            if ($to->gt($end)) $to = $end->copy();

            $weeks[$i] = [
                'minggu' => $i,
                'from'   => $from->copy(),
                'to'     => $to->copy(),
            ];

            $cursor = $to->copy()->addDay()->startOfDay();
            $i++;
        }

        return $weeks; // [1..4/5]
    }

    /**
     * Hitung total per minggu.
     * - Jika ada PenerimaanMingguan(minggu, bulan, tahun) → pakai nilainya (dan bawa flag locked)
     * - Jika tidak ada → hitung dari TransaksiJimpitan di rentang tanggal minggu tsb.
     */
    protected function computeWeeklyTotals($weeks, $bulan, $tahun)
    {
        $result = [];

        // Ambil semua data penerimaan di bulan & tahun tsb
        $rows = PenerimaanMingguan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('minggu')
            ->get();

        foreach ($rows as $row) {
            $result[] = [
                'label' => "Minggu {$row->minggu}",
                'total' => $row->total,
                'locked' => (bool) $row->locked,
                'alasan_hapus' => $row->alasan_hapus,
            ];
        }

        return $result;
    }



    public function cetakMingguan(Request $request)
    {
        [$bulan, $tahun] = $this->resolvePeriode($request);

        $data = $this->computeWeeklyTotals([], $bulan, $tahun);
        $total_bulan = collect($data)->sum('total');

        return view('modules.cetak.laporan.cetak_mingguan', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'items' => $data,
            'total_bulan' => $total_bulan,
        ]);
    }


    // ===================== Laporan BKU Bulanan =====================
    public function bkuBulananIndex()
    {
        return view('laporan.bku_bulanan.index');
    }

    public function bkuBulananJson(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $items = BkuLengkap::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('tanggal')
            ->get();

        return response()->json([
            'bulan' => (int) $bulan,
            'tahun' => (int) $tahun,
            'items' => $items,
            'total_masuk' => $items->sum('dana_masuk'),
            'total_keluar' => $items->sum('dana_keluar'),
            'saldo_awal' => optional($items->firstWhere('is_saldo_awal', true))->saldo ?? 0,
            'saldo_akhir' => optional($items->firstWhere('is_saldo_akhir', true))->saldo ?? 0,
        ]);
    }

    public function bkuBulananCetak(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $items = BkuLengkap::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('tanggal')
            ->get();

        $total_masuk   = (int) $items->sum('dana_masuk');
        $total_keluar  = (int) $items->sum('dana_keluar');
        $saldo_awal    = (int) (optional($items->firstWhere('is_saldo_awal', true))->saldo ?? ($items->first()->saldo ?? 0));
        $saldo_akhir   = (int) (optional($items->firstWhere('is_saldo_akhir', true))->saldo ?? ($items->last()->saldo ?? 0));

        // ambil tanggal terakhir bulan
        $tanggal_akhir = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        return view('modules.cetak.laporan.cetak_bku_bulanan', compact(
            'items',
            'bulan',
            'tahun',
            'total_masuk',
            'total_keluar',
            'saldo_awal',
            'saldo_akhir',
            'tanggal_akhir'
        ));
    }


    // ===================== Laporan Pengeluaran =====================
    public function pengeluaranIndex()
    {
        return view('laporan.pengeluaran.index');
    }

    public function pengeluaranJson(Request $request)
    {
        $query = PengeluaranJimpitan::with('kategori')->orderBy('tanggal');

        // Filter kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $items = $query->get();

        return response()->json([
            'items' => $items,
            'total' => $items->sum('jumlah'),
        ]);
    }

    public function pengeluaranCetak(Request $request)
    {
        $query = PengeluaranJimpitan::with('kategori')->orderBy('tanggal');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $items = $query->get();

        $total = $items->sum('jumlah');

        return view('modules.cetak.laporan.cetak_pengeluaran', compact(
            'items',
            'total'
        ));
    }
}
