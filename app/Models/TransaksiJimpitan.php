<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiJimpitan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_jimpitan';

    protected $fillable = [
        'warga_id',
        'user_id',
        'tanggal',
        'jumlah',
        'keterangan',
    ];

    /**
     * Relasi ke Warga
     */
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    /**
     * Relasi ke User (petugas)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'tanggal' => 'date', // <-- ini yang penting
        'jumlah'  => 'integer', // biar format uang rapi
    ];
}
