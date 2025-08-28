<?php

namespace App\Services\Jimpitan;

use App\Models\Warga;
use App\Models\TransaksiJimpitan;
use Carbon\Carbon;

class WhatsappService
{
    public function generateMessage(TransaksiJimpitan $transaksi): array
    {
        $warga = $transaksi->warga;
        $petugas = $transaksi->user->name;
        $jumlahFormatted = number_format($transaksi->jumlah, 0, ',', '.');

        // langsung pakai Carbon instance dari Eloquent
        $tanggalFormatted = $transaksi->tanggal->translatedFormat('d F Y');

        $message = "Halo Bapak/Ibu *{$warga->nama_kk}*,\n\n"
            . "Jimpitan Anda sebesar *Rp {$jumlahFormatted}* pada tanggal *{$tanggalFormatted}* "
            . "telah dicatat oleh petugas *{$petugas}*.\n\n"
            . "Terima kasih atas partisipasi dan kontribusi Anda! \n\n"
            . "Anda dapat mengecek seluruh data transaksi jimpitan di:\n"
            . "*https://jimpitan.remaked.web.id*";

        $nomor = preg_replace('/^0/', '62', $warga->no_telp);
        $waUrl = "https://wa.me/{$nomor}?text=" . urlencode($message);

        return [
            'message' => $message,
            'wa_url' => $waUrl,
            'warga' => $warga->nama_kk,
            'tanggal' => $tanggalFormatted,
            'jumlah' => $jumlahFormatted,
        ];
    }
}
