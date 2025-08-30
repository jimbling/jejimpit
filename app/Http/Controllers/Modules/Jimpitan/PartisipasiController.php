<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use Illuminate\Http\Request;
use App\Models\TransaksiJimpitan;
use App\Http\Controllers\Controller;
use App\Services\Jimpitan\WhatsappService;
use App\Services\Jimpitan\PartisipasiService;

class PartisipasiController extends Controller
{
    protected $partisipasiService;

    public function __construct(PartisipasiService $partisipasiService)
    {
        $this->partisipasiService = $partisipasiService;
    }

    /**
     * Index: tampilkan semua warga + total setor
     */
    public function index()
    {
        $wargas = $this->partisipasiService->getRekapSemuaWarga();

        return view('modules.cetak.laporan.partisipasi', [
            'wargas'      => $wargas,
            'totalWargas' => $wargas->count(),
            'title' => 'Partisipasi Jimpitan Warga',
            'breadcrumbs' => $this->partisipasiService->getBreadcrumbs(),
        ]);
    }

    /**
     * Detail transaksi per warga
     */
    public function showWarga($id)
    {
        $warga = $this->partisipasiService->getDetailWarga($id);

        // gunakan relationship query builder, bukan collection
        $transaksis = $warga->transaksiJimpitan()
            ->with('user')
            ->orderBy('tanggal', 'desc')
            ->paginate(request('perPage', 10));

        return view('modules.cetak.laporan.partials._partisipasi_detail', compact('warga', 'transaksis'));
    }

    public function getTransaksi(Request $request, $id)
    {
        $warga = $this->partisipasiService->getDetailWarga($id);

        $query = $warga->transaksiJimpitan()->with('user')->orderBy('tanggal', 'desc');

        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('tanggal', [$request->start, $request->end]);
        }

        $transaksis = $query->paginate($request->get('perPage', 10))->withQueryString();

        return view('modules.cetak.laporan.partials._table_detail_partisipasi', compact('transaksis'));
    }




    public function getTransaksiByDate($id)
    {
        $start = request()->query('start');
        $end   = request()->query('end');

        $warga = $this->partisipasiService->getDetailWargaWithFilter($id, $start, $end);

        // return partial view biar rapi, bukan JSON
        return view('modules.cetak.laporan.partials._table_detail_partisipasi', [
            'transaksis' => $warga->transaksiJimpitan
        ]);
    }

    public function print($id)
    {
        $start = request()->query('start');
        $end   = request()->query('end');

        $warga = $this->partisipasiService->getDetailWargaWithFilter($id, $start, $end);

        // Ambil transaksi sesuai rentang
        $transaksi = $warga->transaksiJimpitan()
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        // Hitung total
        $total = $transaksi->sum('jumlah');

        return view('modules.cetak.laporan.cetak_partisipasi', [
            'warga'      => $warga,
            'transaksi'  => $transaksi,
            'total'      => $total,
            'start'      => $start,
            'end'        => $end,
            'title'      => 'Laporan Partisipasi Jimpitan',
        ]);
    }

    public function sendWa($id)
    {
        $start = request()->query('start');
        $end   = request()->query('end');

        $warga = $this->partisipasiService->getDetailWargaWithFilter($id, $start, $end);

        $transaksi = $warga->transaksiJimpitan()
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        $total = $transaksi->sum('jumlah');

        $pesan = "*LAPORAN PARTISIPASI JIMPITAN 63* \n"
            . "Nama: {$warga->nama_kk}\n"
            . "Periode: {$start} s/d {$end}\n\n";

        foreach ($transaksi as $trx) {
            $tanggal = \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d F Y');
            $pesan .= "- {$tanggal} : Rp " . number_format($trx->jumlah, 0, ',', '.') . "\n";
        }

        $totalFormatted = number_format($total, 0, ',', '.');
        $pesan .= "\nTotal: Rp {$totalFormatted}\n\n";
        // Tambahkan pesan informasi
        $pesan .= "Anda dapat mengecek seluruh data transaksi jimpitan di:\n";
        $pesan .= "*https://jimpitan.remaked.web.id*\n\n";
        $pesan .= "Ini adalah pesan informasi tentang jimpitan otomatis oleh sistem, "
            . "tidak perlu membalasnya. Terima kasih";
        // Format no hp (pastikan di DB sudah 628xx bukan 08xx)
        $phone = $warga->no_hp;

        $url = "https://wa.me/{$phone}?text=" . urlencode($pesan);

        return redirect($url);
    }
}
