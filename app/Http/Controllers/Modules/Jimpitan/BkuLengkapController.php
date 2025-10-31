<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\BkuLengkap;
use App\Services\Jimpitan\BkuLengkapService;

class BkuLengkapController extends Controller
{

    protected $bkuLengkapService;

    public function __construct(BkuLengkapService $bkuLengkapService)
    {
        $this->bkuLengkapService = $bkuLengkapService;
    }

    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $q = $request->get('q');

        $bku = BkuLengkap::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->when($q, fn($query) => $query->where('uraian', 'like', "%$q%"))
            ->orderBy('tanggal')
            ->orderBy('no')
            ->get();

        // Jika request AJAX, kembalikan tabel saja
        if ($request->ajax()) {
            return view('modules.jimpitan.bku._table', compact('bku', 'bulan', 'tahun'))->render();
        }

        // Kalau normal, render halaman full
        return view('modules.jimpitan.bku-lengkap', [
            'title' => 'Buku Kas Umum (BKU) Lengkap',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bku' => $bku,
            'breadcrumbs' => $this->bkuLengkapService->getBreadcrumbs(),
        ]);
    }




    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        // Jalankan Artisan command
        Artisan::call('bku:generate', [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);

        return redirect()
            ->route('bku.lengkap.index', [
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
            ])
            ->with('success', '✅ BKU Lengkap berhasil digenerate!');
    }

    public function hapusBku(Request $request)
    {
        // Ambil dari POST (form input hidden)
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $deleted = BkuLengkap::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->delete();

        return redirect()->route('bku.lengkap.index')
            ->with('success', "Berhasil menghapus {$deleted} data BKU bulan {$bulan} tahun {$tahun}");
    }
}
