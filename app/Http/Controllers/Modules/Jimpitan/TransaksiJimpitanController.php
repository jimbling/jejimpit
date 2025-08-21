<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use Illuminate\Http\Request;
use App\Models\TransaksiJimpitan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Jimpitan\TransaksiService;

class TransaksiJimpitanController extends Controller
{
    protected $transaksiService;

    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    public function index(Request $request)
    {
        $transaksi = TransaksiJimpitan::with(['warga', 'user'])
            ->orderBy('tanggal', 'asc') // default urut berdasarkan tanggal
            ->get();

        $wargas = \App\Models\Warga::where('status', 'aktif')->orderBy('nama_kk')->get();

        return view('modules.jimpitan.transaksi', [
            'transaksi' => $transaksi,
            'wargas'    => $wargas, // <-- tambahkan ini
            'title'     => 'Transaksi Jimpitan',
            'breadcrumbs' => $this->transaksiService->getBreadcrumbs(),
        ]);
    }


    /**
     * Simpan transaksi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id'   => 'required|exists:warga,id',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Tambahkan user_id otomatis
        $validated['user_id'] = Auth::id();

        TransaksiJimpitan::create($validated);

        return redirect()->back()->with('success', 'Transaksi jimpitan berhasil ditambahkan.');
    }

    /**
     * Hapus satu transaksi
     */
    public function destroy($id)
    {
        $transaksi = TransaksiJimpitan::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Hapus banyak transaksi sekaligus
     */
    public function massDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            TransaksiJimpitan::whereIn('id', $ids)->delete();
        }

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
