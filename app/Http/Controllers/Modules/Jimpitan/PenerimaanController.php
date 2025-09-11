<?php


namespace App\Http\Controllers\Modules\Jimpitan;

use Carbon\Carbon;
use App\Models\BkuLengkap;
use Illuminate\Http\Request;
use App\Models\PenerimaanBulanan;
use App\Models\TransaksiJimpitan;
use App\Models\PenerimaanMingguan;
use App\Http\Controllers\Controller;
use App\Models\PengeluaranJimpitan;
use App\Services\Jimpitan\PenerimaanService;

class PenerimaanController extends Controller
{

    protected $penerimaanService;

    public function __construct(PenerimaanService $penerimaanService)
    {
        $this->penerimaanService = $penerimaanService;
    }

    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $penerimaanMingguan = PenerimaanMingguan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('minggu')
            ->get();

        $penerimaanBulanan = PenerimaanBulanan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        return view('modules.jimpitan.penerimaan', [
            'title' => 'Data Penerimaan Jimpitan',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'penerimaanMingguan' => $penerimaanMingguan,
            'penerimaanBulanan' => $penerimaanBulanan,
            'breadcrumbs' => $this->penerimaanService->getBreadcrumbs(),
        ]);
    }


    public function generateMingguan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Hapus yang belum locked
        PenerimaanMingguan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('locked', false)
            ->delete();

        $carbon = Carbon::create($tahun, $bulan, 1);
        $daysInMonth = $carbon->daysInMonth;

        $minggu = 1;
        $startDay = 1;

        while ($startDay <= $daysInMonth) {
            $endDay = min($startDay + 6, $daysInMonth); // kelompok per 7 hari
            $start = Carbon::create($tahun, $bulan, $startDay)->startOfDay();
            $end   = Carbon::create($tahun, $bulan, $endDay)->endOfDay();

            $total = TransaksiJimpitan::whereBetween('tanggal', [$start, $end])->sum('jumlah');

            PenerimaanMingguan::create([
                'minggu' => $minggu,
                'bulan'  => $bulan,
                'tahun'  => $tahun,
                'total'  => $total,
            ]);

            $minggu++;
            $startDay += 7;
        }

        return redirect()->back()->with('success', 'Penerimaan Mingguan berhasil digenerate');
    }


    public function generateBulanan(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        // Hapus yang belum locked
        PenerimaanBulanan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('locked', false)
            ->delete();

        // cari saldo akhir bulan sebelumnya dari BKU Lengkap
        $prevBulan = $bulan == 1 ? 12 : $bulan - 1;
        $prevTahun = $bulan == 1 ? $tahun - 1 : $tahun;

        $prevSaldo = BkuLengkap::where('bulan', $prevBulan)
            ->where('tahun', $prevTahun)
            ->where('is_saldo_akhir', 1)
            ->value('saldo');

        $saldoAwal = $prevSaldo ?? 0;

        // hitung total penerimaan bulan ini
        $totalPenerimaan = TransaksiJimpitan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        // hitung total pengeluaran bulan ini (kalau mau lebih akurat saldo_akhir)
        $totalPengeluaran = PengeluaranJimpitan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $saldoAkhir = $saldoAwal + $totalPenerimaan - $totalPengeluaran;

        // simpan ringkasan
        PenerimaanBulanan::create([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'saldo_awal' => $saldoAwal,
            'total_penerimaan' => $totalPenerimaan,
            'saldo_akhir' => $saldoAkhir,
        ]);

        return redirect()->back()->with('success', 'BKU Bulanan berhasil digenerate');
    }


    public function lockMingguan($id)
    {
        $bku = PenerimaanMingguan::findOrFail($id);
        $bku->locked = true;
        $bku->save();

        return redirect()->back()->with('success', 'Penerimaan Mingguan dikunci');
    }

    public function lockBulanan($id)
    {
        $bku = PenerimaanBulanan::findOrFail($id);
        $bku->locked = true;
        $bku->save();

        return redirect()->back()->with('success', 'Penerimaan Bulanan dikunci');
    }

    public function hapusMingguan($id)
    {
        $bku = PenerimaanMingguan::findOrFail($id);

        if ($bku->locked) {
            return redirect()->back()->with('error', 'Penerimaan Mingguan sudah dikunci, tidak bisa dihapus');
        }

        $bku->delete();
        return redirect()->back()->with('success', 'Penerimaan Mingguan berhasil dihapus');
    }

    public function hapusBulanan($id)
    {
        $bku = PenerimaanBulanan::findOrFail($id);

        if ($bku->locked) {
            return redirect()->back()->with('error', 'Penerimaan Bulanan sudah dikunci, tidak bisa dihapus');
        }

        $bku->delete();
        return redirect()->back()->with('success', 'Penerimaan Bulanan berhasil dihapus');
    }
}
