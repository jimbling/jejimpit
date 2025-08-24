<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\BkuLengkap;
use Illuminate\Console\Command;
use App\Models\PenerimaanBulanan;
use App\Models\TransaksiJimpitan;
use App\Models\PengeluaranJimpitan;

class GenerateBkuLengkap extends Command
{
    protected $signature = 'bku:generate {bulan} {tahun}';
    protected $description = 'Generate BKU Lengkap per bulan';

    public function handle()
    {
        $bulan = (int) $this->argument('bulan');
        $tahun = (int) $this->argument('tahun');

        $this->info("🔄 Membuat BKU Lengkap untuk $bulan/$tahun ...");

        // Hitung saldo awal
        $prevBulan = $bulan - 1;
        $prevTahun = $tahun;
        if ($bulan === 1) {
            $prevBulan = 12;
            $prevTahun = $tahun - 1;
        }

        $saldoAwal = PenerimaanBulanan::where('bulan', $prevBulan)
            ->where('tahun', $prevTahun)
            ->value('saldo_akhir') ?? 0;

        $data = collect();

        // 1. Baris saldo awal
        $data->push([
            'no' => 1,
            'tanggal' => Carbon::create($tahun, $bulan, 1)->toDateString(),
            'uraian' => 'Saldo Bulan Lalu',
            'dana_masuk' => 0,
            'dana_keluar' => 0,
            'saldo' => $saldoAwal,
            'is_saldo_awal' => true,
            'is_saldo_akhir' => false,
        ]);

        // 2. Ambil penerimaan
        $penerimaan = TransaksiJimpitan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->map(fn($t) => [
                'tanggal' => $t->tanggal,
                'uraian' => $t->keterangan ?? 'Penerimaan Jimpitan',
                'dana_masuk' => $t->jumlah,
                'dana_keluar' => 0,
            ]);

        // 3. Ambil pengeluaran
        $pengeluaran = PengeluaranJimpitan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->map(fn($t) => [
                'tanggal' => $t->tanggal,
                'uraian' => $t->uraian,
                'dana_masuk' => 0,
                'dana_keluar' => $t->jumlah,
            ]);

        // 4. Gabung dan urutkan
        $transaksi = $penerimaan->merge($pengeluaran)->sortBy('tanggal');

        // 5. Hitung saldo berjalan
        $saldo = $saldoAwal;
        $no = 2;
        foreach ($transaksi as $t) {
            $saldo += ($t['dana_masuk'] ?? 0) - ($t['dana_keluar'] ?? 0);
            $data->push([
                'no' => $no++,
                'tanggal' => $t['tanggal'],
                'uraian' => $t['uraian'],
                'dana_masuk' => $t['dana_masuk'] ?? 0,
                'dana_keluar' => $t['dana_keluar'] ?? 0,
                'saldo' => $saldo,
                'is_saldo_awal' => false,
                'is_saldo_akhir' => false,
            ]);
        }

        // 6. Baris saldo akhir
        $lastDate = Carbon::create($tahun, $bulan, 1)->endOfMonth()->toDateString();
        $data->push([
            'no' => $no,
            'tanggal' => $lastDate,
            'uraian' => 'Saldo Akhir',
            'dana_masuk' => 0,
            'dana_keluar' => 0,
            'saldo' => $saldo,
            'is_saldo_awal' => false,
            'is_saldo_akhir' => true,
        ]);

        // 7. Simpan ke DB
        BkuLengkap::where('bulan', $bulan)->where('tahun', $tahun)->delete();
        BkuLengkap::insert($data->map(fn($d) => array_merge($d, [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'created_at' => now(),
            'updated_at' => now(),
        ]))->toArray());

        $this->info("✅ BKU Lengkap untuk $bulan/$tahun berhasil dibuat!");
    }
}
