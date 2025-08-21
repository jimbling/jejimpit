<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga'; // nama tabel

    protected $fillable = [
        'kode_unik',
        'nama_kk',
        'alamat',
        'rt',
        'rw',
        'no_rumah',
        'no_telp',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($warga) {
            // Generate kode_unik jika belum ada
            if (!$warga->kode_unik) {
                $prefix = 'KDT';
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

                do {
                    $random = '';
                    for ($i = 0; $i < 3; $i++) {
                        $random .= $characters[random_int(0, strlen($characters) - 1)];
                    }
                    $kode = $prefix . $random;
                } while (self::where('kode_unik', $kode)->exists());

                $warga->kode_unik = $kode;
            }
        });
    }

    public function transaksiJimpitan()
    {
        return $this->hasMany(TransaksiJimpitan::class, 'warga_id');
    }
}
