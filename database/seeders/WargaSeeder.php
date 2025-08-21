<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WargaSeeder extends Seeder
{
    public function run()
    {
        $prefix = 'KDT'; // nanti ambil dari setting kalau sudah ada
        $jumlah = 50;

        $nama_depan = ['Adi', 'Budi', 'Cahyo', 'Dwi', 'Eka', 'Fajar', 'Galih', 'Hadi', 'Indra', 'Joko', 'Kurnia', 'Lestari', 'Mega', 'Novi', 'Putri', 'Rini', 'Sari', 'Teguh', 'Wulan', 'Yudha'];
        $nama_belakang = ['Santoso', 'Pratama', 'Saputra', 'Wijaya', 'Haryanto', 'Purnama', 'Setiawan', 'Gunawan', 'Kusuma', 'Utama', 'Wibowo', 'Maulana', 'Ramadhan', 'Putra', 'Susanto', 'Handayani', 'Pratiwi', 'Lestari', 'Cahyono', 'Rahayu'];

        for ($i = 1; $i <= $jumlah; $i++) {
            $no_rumah = str_pad($i, 3, '0', STR_PAD_LEFT); // 001, 002, ...
            $kode_unik = $prefix . $no_rumah;

            $rt = str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT); // RT 01-05
            $rw = str_pad(rand(1, 3), 2, '0', STR_PAD_LEFT); // RW 01-03

            // generate nama random
            $nama_kk = $nama_depan[array_rand($nama_depan)] . ' ' . $nama_belakang[array_rand($nama_belakang)];

            DB::table('warga')->insert([
                'kode_unik' => $kode_unik,
                'nama_kk' => $nama_kk,
                'alamat' => 'Jl. Contoh Alamat No. ' . $i,
                'rt' => $rt,
                'rw' => $rw,
                'no_rumah' => str_pad($i, 2, '0', STR_PAD_LEFT),
                'no_telp' => '0812' . rand(1000000, 9999999),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
