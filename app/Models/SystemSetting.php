<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class SystemSetting extends Model
{
    // Nama tabel jika tidak sesuai dengan konvensi Laravel (opsional jika pakai nama 'system_settings')
    protected $table = 'system_settings';

    // Isi kolom yang boleh diisi massal
    protected $fillable = [
        'nama_rt',
        'nama_koordinator',
        'nama_dusun',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'negara',
        'kode_pos',
        'website',
        'email',
        'no_telp',
        'logo',
        'favicon',
        'kop_sekolah',
        'qrcode_logo',
    ];

    // Jika ingin menonaktifkan timestamps (kalau misal tidak pakai created_at dan updated_at)
    // public $timestamps = false;
}
