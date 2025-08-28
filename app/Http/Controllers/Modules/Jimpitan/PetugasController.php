<?php

namespace App\Http\Controllers\Modules\Jimpitan;

use App\Models\Warga;
use App\Models\Checkin;
use App\Models\Jimpitan;
use Illuminate\Http\Request;
use App\Models\TransaksiJimpitan;
use App\Http\Controllers\Controller;
use App\Services\Jimpitan\KehadiranService;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();
        $tanggal = $request->tanggal;

        // Cek check-in
        $checkin = Checkin::where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$checkin) {
            return redirect()->back()->withErrors(['Anda belum melakukan check-in hari ini.']);
        }

        // Simpan transaksi
        $transaksi = TransaksiJimpitan::create([
            'user_id' => $userId,
            'warga_id' => $request->warga_id,
            'tanggal' => $tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        // Update jumlah transaksi di Checkin
        $checkin->jumlah_transaksi = TransaksiJimpitan::where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->count();
        $checkin->save();

        // Ambil data warga & petugas
        $warga = Warga::find($request->warga_id);
        $petugas = auth()->user()->name;
        $jumlahFormatted = number_format($request->jumlah, 0, ',', '.');

        // Format tanggal lokal
        $tanggalCarbon = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggal);
        $tanggalFormatted = $tanggalCarbon->translatedFormat('d F Y');

        // Buat pesan WhatsApp lebih estetik untuk seluruh data jimpitan
        $message = "Halo Bapak/Ibu *{$warga->nama_kk}*,\n\n"
            . "Jimpitan Anda sebesar *Rp {$jumlahFormatted}* pada tanggal *{$tanggalFormatted}* "
            . "telah dicatat oleh petugas *{$petugas}*.\n\n"
            . "Terima kasih atas partisipasi dan kontribusi Anda! 🙏\n\n"
            . "Anda dapat mengecek seluruh data transaksi jimpitan (penerimaan, pengeluaran, dll) di:\n"
            . "*https://jimpitan.remaked.web.id*";


        // Nomor WA warga (ubah 0 diawal jadi 62)
        $nomor = preg_replace('/^0/', '62', $warga->no_telp);
        $waUrl = "https://wa.me/{$nomor}?text=" . urlencode($message);

        // Redirect ke dashboard dengan session
        return redirect()->route('petugas.home')->with('jimpitan_success', [
            'warga' => $warga->nama_kk,
            'tanggal' => $tanggalFormatted,
            'jumlah' => $jumlahFormatted,
            'wa_url' => $waUrl, // ini untuk tombol WA di alert
        ]);
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
