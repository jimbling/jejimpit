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
        $query = TransaksiJimpitan::with(['warga', 'user'])->orderBy('tanggal', 'asc');

        // Filter Warga
        if ($request->filled('warga_id')) {
            $query->where('warga_id', $request->warga_id);
        }

        // Filter Petugas
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter Tanggal hanya jika diisi
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $transaksi = $query->get();


        // Jika request AJAX, kirim partial table saja
        if ($request->ajax()) {
            return view('modules.jimpitan.transaksi.table', compact('transaksi'))->render();
        }

        $wargas = \App\Models\Warga::where('status', 'aktif')->orderBy('nama_kk')->get();
        $users  = \App\Models\User::orderBy('name')->get();

        return view('modules.jimpitan.transaksi', compact('transaksi', 'wargas', 'users'));
    }



    /**
     * Simpan transaksi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id'   => 'required|exists:warga,id',
            'user_id'    => 'required|exists:users,id',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

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
}
