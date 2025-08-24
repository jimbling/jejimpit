<?php


namespace App\Http\Controllers\Modules\Jimpitan;

use Illuminate\Http\Request;
use App\Models\penerimaanMingguan;
use App\Models\PenerimaanBulanan;
use App\Models\TransaksiJimpitan;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class PenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $penerimaanMingguan = penerimaanMingguan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('minggu')
            ->get();

        $penerimaanBulanan = PenerimaanBulanan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        return view('modules.jimpitan.penerimaan', compact('penerimaanMingguan', 'penerimaanBulanan', 'bulan', 'tahun'));
    }

    public function generateMingguan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Hapus yang belum locked
        penerimaanMingguan::where('bulan', $bulan)->where('tahun', $tahun)->where('locked', false)->delete();

        // Hitung minggu dalam bulan
        $carbon = Carbon::create($tahun, $bulan, 1);
        $totalMinggu = $carbon->daysInMonth / 7;

        for ($i = 1; $i <= ceil($totalMinggu); $i++) {
            $start = $carbon->copy()->startOfMonth()->addWeeks($i - 1);
            $end = $start->copy()->endOfWeek();

            $total = TransaksiJimpitan::whereBetween('tanggal', [$start, $end])->sum('jumlah');

            penerimaanMingguan::create([
                'minggu' => $i,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'total' => $total,
            ]);
        }

        return redirect()->back()->with('success', 'Penerimaan Mingguan berhasil digenerate');
    }

    public function generateBulanan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Hapus yang belum locked
        PenerimaanBulanan::where('bulan', $bulan)->where('tahun', $tahun)->where('locked', false)->delete();

        $saldoAwal = PenerimaanBulanan::where('bulan', $bulan - 1)->where('tahun', $tahun)->value('saldo_akhir') ?? 0;
        $totalPenerimaan = TransaksiJimpitan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');
        $saldoAkhir = $saldoAwal + $totalPenerimaan;

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
        $bku = penerimaanMingguan::findOrFail($id);
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
        $bku = penerimaanMingguan::findOrFail($id);

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
