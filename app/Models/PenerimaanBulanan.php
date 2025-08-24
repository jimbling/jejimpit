<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBulanan extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_bulanan';

    protected $fillable = [
        'bulan',
        'tahun',
        'saldo_awal',
        'total_penerimaan',
        'saldo_akhir',
        'locked',
        'alasan_hapus',
    ];

    protected $casts = [
        'locked' => 'boolean',
        'saldo_awal' => 'integer',
        'total_penerimaan' => 'integer',
        'saldo_akhir' => 'integer',
    ];
}
