<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use App\Models\Warga;
use App\Models\WaQueue;
use App\Jobs\ProcessWaQueue;
use Illuminate\Http\Request;
use App\Models\TransaksiJimpitan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\Jimpitan\WhatsappService;
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
            return view('modules.jimpitan.transaksi.table', [
                'transaksi' => $transaksi,
            ])->render();
        }

        $wargas = \App\Models\Warga::where('status', 'aktif')->orderBy('nama_kk')->get();
        $users  = \App\Models\User::orderBy('name')->get();

        return view('modules.jimpitan.transaksi', [
            'title'       => 'Data Transaksi Jimpitan',
            'transaksi'   => $transaksi,
            'wargas'      => $wargas,
            'users'       => $users,
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
            'user_id'    => 'required|exists:users,id',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        return DB::transaction(function () use ($validated) {
            // Simpan transaksi jimpitan
            $transaksi = TransaksiJimpitan::create($validated);

            // Generate pesan WA
            $whatsappService = new WhatsappService();
            $waData = $whatsappService->generateMessage($transaksi);

            // Ambil scheduled terakhir, tambah 1 detik supaya unik
            $lastScheduled = WaQueue::latest('scheduled_at')->value('scheduled_at') ?? now();
            $scheduledAt = $lastScheduled->addSecond();

            // Simpan ke tabel queue
            $waQueue = WaQueue::create([
                'transaksi_id' => $transaksi->id,
                'warga_id'    => $transaksi->warga_id,
                'message'     => $waData['message'],
                'status'      => 'pending',
                'scheduled_at' => $scheduledAt,
            ]);

            // Kirim ke job queue
            ProcessWaQueue::dispatch($waQueue)->delay($waQueue->scheduled_at);

            return redirect()->back()->with('success', 'Transaksi jimpitan berhasil ditambahkan & WA masuk antrian.');
        });
    }


    public function resendWhatsapp($id, WhatsappService $wa)
    {
        $transaksi = TransaksiJimpitan::with(['warga', 'user'])->findOrFail($id);

        $waData = $wa->generateMessage($transaksi);

        // Langsung buka halaman wa.me
        return redirect()->away($waData['wa_url']);
    }

    public function resendWhatsappJiget($id, WhatsappService $whatsappService)
    {
        $transaksi = TransaksiJimpitan::with(['warga', 'user'])->findOrFail($id);

        // 🔄 Generate pesan WA
        $waData = $whatsappService->generateMessage($transaksi);

        try {
            // 📲 Kirim ulang pesan via Node.js WA Gateway dengan token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.wagateway.token'),
            ])->post(config('services.wagateway.url') . '/api/wa/send', [
                'number' => preg_replace('/^0/', '62', $transaksi->warga->no_telp),
                'message' => $waData['message'],
            ]);

            $waResponse = $response->json();

            if (!empty($waResponse['success'])) {
                $pesan = "Pesan ke {$transaksi->warga->nama_kk} berhasil dikirim ulang.";
            } else {
                $errorMsg = $waResponse['error'] ?? 'Unknown';
                $pesan = "Gagal mengirim pesan ke {$transaksi->warga->nama_kk}. Error: $errorMsg";

                // 💡 Log error meskipun bukan exception
                Log::error('WA Gateway Response Error', [
                    'transaksi_id' => $transaksi->id,
                    'number' => $transaksi->warga->no_telp,
                    'response' => $waResponse,
                ]);
            }
        } catch (\Throwable $e) {
            // 🛑 Tangani error koneksi / request
            $pesan = "Gagal mengirim pesan ke {$transaksi->warga->nama_kk}. Exception: " . $e->getMessage();
            Log::error('WA Gateway Error: ' . $e->getMessage(), [
                'transaksi_id' => $transaksi->id,
                'number' => $transaksi->warga->no_telp,
            ]);
        }

        return redirect()->route('transaksi.jimpitan.index')
            ->with('jimpitan_success', $pesan);
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
