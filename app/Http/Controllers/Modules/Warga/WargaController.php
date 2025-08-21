<?php

namespace App\Http\Controllers\Modules\Warga;

use App\Models\Warga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Warga\WargaService;

class WargaController extends Controller
{
    protected $wargaService;

    public function __construct(WargaService $wargaService)
    {
        $this->wargaService = $wargaService;
    }

    public function index(Request $request)
    {
        $wargas = $this->wargaService->getFilteredWargas($request->all());

        return view('modules.warga.data-warga', [
            'title' => 'Data Warga',
            'breadcrumbs' => $this->wargaService->getBreadcrumbs(),
            'wargas' => $wargas,
            'totalWargas' => $wargas->count(),
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_kk'   => 'required|string|max:100',
            'alamat'    => 'required|string|max:255',
            'rt'        => 'required|string|max:3',
            'rw'        => 'required|string|max:3',
            'no_rumah'  => 'required|string|max:10',
            'no_telp'   => 'nullable|string|max:20',
            'status'    => 'required|in:aktif,nonaktif',
        ]);

        // Simpan ke database → kode_unik otomatis di-generate oleh model
        Warga::create($validated);

        // Redirect dengan flash message
        return redirect()->route('induk.warga')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }



    public function destroy($id)
    {
        $warga = Warga::findOrFail($id); // atau kalau pakai UUID: Warga::where('uuid', $uuid)->firstOrFail()
        $warga->delete();

        return back()->with('success', 'Warga berhasil dihapus.');
    }

    /**
     * Hapus banyak warga sekaligus
     */
    public function massDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            Warga::whereIn('id', $ids)->delete();
        }

        return redirect()->route('induk.warga') // pastikan route ini sesuai
            ->with('success', 'Data warga berhasil dihapus.');
    }
}
