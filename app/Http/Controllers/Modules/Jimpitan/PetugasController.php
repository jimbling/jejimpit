<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use App\Models\Warga;
use App\Models\Checkin;
use App\Models\Jimpitan;
use Illuminate\Http\Request;
use App\Models\TransaksiJimpitan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\Jimpitan\FonnteService;
use App\Services\Jimpitan\WhatsappService;
use App\Services\Jimpitan\KehadiranService;

class PetugasController extends Controller
{



    public function index()
    {
        $petugas = auth()->user();
        $today = now()->toDateString();

        // Cek apakah sudah check-in hari ini
        $sudahCheckin = Checkin::where('user_id', $petugas->id)
            ->whereDate('tanggal', $today)
            ->exists();

        return view('modules.petugas.home', compact('sudahCheckin'));
    }


    /**
     * Tampilkan form tambah entri jimpitan (mobile friendly)
     */
    public function create()
    {
        $wargas = Warga::all();
        return view('modules.petugas.entri-jimpitan', compact('wargas'));
    }

    /**
     * Simpan entri jimpitan baru
     */
    public function store(Request $request, WhatsappService $whatsappService)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();
        $tanggal = $request->tanggal;

        return DB::transaction(function () use ($request, $whatsappService, $userId, $tanggal) {
            // 🔒 Lock baris checkin untuk user & tanggal ini (agar tidak diakses bersamaan)
            $checkin = Checkin::where('user_id', $userId)
                ->whereDate('tanggal', $tanggal)
                ->lockForUpdate()
                ->first();

            if (!$checkin) {
                throw new \Exception('Anda belum melakukan check-in hari ini.');
            }

            // Buat transaksi
            $transaksi = TransaksiJimpitan::create([
                'user_id' => $userId,
                'warga_id' => $request->warga_id,
                'tanggal' => $tanggal,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);

            // Hitung ulang jumlah transaksi (pasti akurat karena sudah di-lock)
            $checkin->jumlah_transaksi = TransaksiJimpitan::where('user_id', $userId)
                ->whereDate('tanggal', $tanggal)
                ->count();
            $checkin->save();

            // Generate pesan WA
            $waData = $whatsappService->generateMessage($transaksi);

            // Kirim WA (ini di luar transaksi, supaya kalau gagal WA tetap data transaksi tersimpan)
            $response = Http::withHeaders([
                'Authorization' => config('services.fonnte.token'), // token dari config
            ])->post('https://api.fonnte.com/send', [
                'target' => preg_replace('/^0/', '62', $transaksi->warga->no_telp),
                'message' => $waData['message'],
                'countryCode' => '62',
            ]);

            $waData['fonnte_response'] = $response->json();

            return redirect()->route('petugas.home')->with('jimpitan_success', $waData);
        });
    }



    public function riwayat()
    {
        $userId = Auth::id();

        $transaksi = TransaksiJimpitan::with('warga')
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'warga_nama' => $t->warga->nama_kk ?? '-',
                    'warga_kode' => $t->warga->kode_unik ?? '-',
                    'tanggal' => $t->tanggal->format('d-m-Y'), // untuk tampilan
                    'tanggal_raw' => $t->tanggal->format('Y-m-d'), // untuk filter JS
                    'jumlah' => $t->jumlah,
                    'keterangan' => $t->keterangan ?? '-',
                ];
            })
            ->toArray();


        return view('modules.petugas.riwayat', compact('transaksi'));
    }
}
