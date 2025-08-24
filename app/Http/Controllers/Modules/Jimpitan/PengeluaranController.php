<?php


namespace App\Http\Controllers\Modules\Jimpitan;

use Carbon\Carbon;
use App\Models\BkuLengkap;
use Illuminate\Http\Request;
use App\Models\PenerimaanBulanan;
use App\Models\TransaksiJimpitan;
use App\Models\penerimaanMingguan;
use App\Models\KategoriPengeluaran;
use App\Models\PengeluaranJimpitan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class PengeluaranController extends Controller
{

    public function index(Request $request)
    {
        // ambil bulan & tahun dari request, default ke bulan & tahun sekarang
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $pengeluaran = PengeluaranJimpitan::with(['kategori', 'user'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString(); // biar pagination tetap bawa query bulan&tahun

        $kategori = KategoriPengeluaran::all();

        return view('modules.jimpitan.pengeluaran', compact('pengeluaran', 'kategori', 'bulan', 'tahun'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'kategori_id' => 'required|exists:kategori_pengeluaran,id',
            'uraian' => 'required|string|max:255',
        ]);

        $tanggal = $request->tanggal;
        $bulan = date('n', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        // ✅ Ambil saldo terakhir pada atau sebelum tanggal transaksi
        $saldoSebelum = BkuLengkap::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('tanggal', '<=', $tanggal)
            ->orderBy('tanggal', 'desc')
            ->orderBy('no', 'desc')
            ->value('saldo');

        if (is_null($saldoSebelum)) {
            // Kalau belum ada transaksi bulan ini, ambil saldo akhir bulan sebelumnya
            $prevBulan = $bulan == 1 ? 12 : $bulan - 1;
            $prevTahun = $bulan == 1 ? $tahun - 1 : $tahun;
            $saldoSebelum = PenerimaanBulanan::where('bulan', $prevBulan)
                ->where('tahun', $prevTahun)
                ->value('saldo_akhir') ?? 0;
        }

        // ✅ Cek apakah saldo cukup
        if ($request->jumlah > $saldoSebelum) {
            return back()->withErrors([
                'jumlah' => "Saldo tidak mencukupi. Saldo per {$tanggal}: " . number_format($saldoSebelum),
            ]);
        }

        // ✅ Simpan pengeluaran
        $pengeluaran = PengeluaranJimpitan::create([
            'tanggal' => $tanggal,
            'jumlah' => $request->jumlah,
            'kategori_id' => $request->kategori_id,
            'uraian' => $request->uraian,
            'user_id' => auth()->id(),
        ]);

        // ✅ Setelah simpan, regenerate BKU bulan ini agar saldo berjalan update
        Artisan::call('bku:generate', [
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dicatat. Saldo berjalan sudah diperbarui.');
    }


    public function destroy(PengeluaranJimpitan $pengeluaran)
    {
        // ❌ Jika data sudah dikunci (misalnya setelah closing), jangan boleh dihapus
        if ($pengeluaran->locked) {
            return back()->withErrors([
                'error' => 'Transaksi ini sudah dikunci dan tidak bisa dihapus.'
            ]);
        }

        $tanggal = $pengeluaran->tanggal;
        $bulan   = (int) date('n', strtotime($tanggal));
        $tahun   = (int) date('Y', strtotime($tanggal));

        //  Hapus data pengeluaran
        $pengeluaran->delete();

        //  Regenerate BKU untuk bulan & tahun terkait
        Artisan::call('bku:generate', [
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dihapus. Saldo & BKU telah diperbarui.');
    }


    public function getSaldo(Request $request)
    {
        $tanggal = $request->get('tanggal');
        if (!$tanggal) {
            return response()->json(['saldo' => 0]);
        }

        $bulan = date('n', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        // cari saldo terakhir sampai tanggal tsb
        $saldo = BkuLengkap::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->whereDate('tanggal', '<=', $tanggal) // ✅ filter tanggal
            ->orderBy('tanggal', 'desc')
            ->orderBy('no', 'desc')
            ->value('saldo');

        if (is_null($saldo)) {
            // kalau BKU bulan ini belum ada data sebelum tanggal tsb, pakai saldo akhir bulan sebelumnya
            $prevBulan = $bulan == 1 ? 12 : $bulan - 1;
            $prevTahun = $bulan == 1 ? $tahun - 1 : $tahun;
            $saldo = BkuLengkap::where('bulan', $prevBulan)
                ->where('tahun', $prevTahun)
                ->orderBy('no', 'desc')
                ->value('saldo') ?? 0;
        }

        return response()->json(['saldo' => $saldo]);
    }
}
