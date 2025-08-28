<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use App\Http\Controllers\Controller;
use App\Services\Jimpitan\PartisipasiService;
use App\Models\TransaksiJimpitan;
use Illuminate\Http\Request;

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
}
