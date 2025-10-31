<?php

namespace App\Http\Controllers\Modules\Warga;

use Mpdf\Mpdf;
use App\Models\Warga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Warga\WargaService;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;


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

    public function export()
    {
        $wargas = Warga::all()->map(function ($warga) {
            $result = (new \Endroid\QrCode\Builder\Builder(
                writer: new \Endroid\QrCode\Writer\PngWriter(),
                data: $warga->kode_unik,
                size: 150,
                margin: 5,
            ))->build();

            $warga->qr_base64 = base64_encode($result->getString());
            return $warga;
        });

        return view('modules.cetak.qr-all', compact('wargas'));
    }



    public function exportSingle($id)
    {
        $warga = Warga::findOrFail($id);

        $mpdf = new \Mpdf\Mpdf([
            'format' => [80, 100], // 10x8 cm (lebar 80mm x tinggi 100mm)
            'orientation' => 'P',
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_left' => 5,
            'margin_right' => 5,
            'default_font' => 'sans-serif'
        ]);

        $result = (new \Endroid\QrCode\Builder\Builder(
            writer: new \Endroid\QrCode\Writer\PngWriter(),
            data: $warga->kode_unik,
            size: 150,
            margin: 5,
        ))->build();

        $qrBase64 = base64_encode($result->getString());

        $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { 
                font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
                background-color: #f8f9fa;
                color: #495057;
            }
            .card {
                border: 1px solid #e9ecef;
                border-radius: 8px;
                background: white;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                padding: 12px;
            }
            .header {
                text-align: center;
                margin-bottom: 10px;
            }
            .title {
                font-size: 14px;
                font-weight: 600;
                color: #2c7be5;
                margin-bottom: 3px;
            }
            .subtitle {
                font-size: 10px;
                color: #6c757d;
                margin-bottom: 8px;
            }
            .qr-container {
                text-align: center;
                margin: 8px 0;
                padding: 5px;
                background: white;
                border-radius: 6px;
            }
            .identitas {
                font-size: 12px;
                font-weight: 600;
                margin: 8px 0;
                padding: 5px;
                background-color: #f8f9fa;
                border-radius: 4px;
                text-align: center;
            }
            .kode-unik {
                font-size: 11px;
                color: #2c7be5;
                font-weight: bold;
            }
            .footer {
                font-size: 9px;
                color: #6c757d;
                text-align: center;
                margin-top: 8px;
                padding-top: 5px;
                border-top: 1px dashed #e9ecef;
            }
            .url {
                font-size: 8px;
                color: #2c7be5;
                font-weight: 500;
                margin-top: 3px;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="header">
                <div class="title">QR-CODE WARGA </div>
                <div class="subtitle">Untuk Scan Petugas Jimpitan</div>
            </div>
            
            <div class="qr-container">
                <img src="data:image/png;base64,' . $qrBase64 . '" style="width: 150px; height: 150px;" />
            </div>
            
            <div class="identitas">
                ' . e($warga->nama_kk) . '<br>
                <span class="kode-unik">' . e($warga->kode_unik) . '</span>
            </div>
            
            <div class="footer">
                Laporan kegiatan jimpitan dapat diakses melalui:<br>
                <span class="url">jimpitan.remaked.web.id</span>
            </div>
        </div>
    </body>
    </html>';

        $mpdf->WriteHTML($html);
        return $mpdf->Output('qrcode_' . $warga->kode_unik . '.pdf', 'I');
    }
}
