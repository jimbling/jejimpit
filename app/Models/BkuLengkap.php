<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BkuLengkap extends Model
{
    use HasFactory;

    protected $table = 'bku_lengkap';

    protected $fillable = [
        'bulan',
        'tahun',
        'no',
        'tanggal',
        'uraian',
        'dana_masuk',
        'dana_keluar',
        'saldo',
        'is_saldo_awal',
        'is_saldo_akhir',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'dana_masuk' => 'integer',
        'dana_keluar' => 'integer',
        'saldo' => 'integer',
        'is_saldo_awal' => 'boolean',
        'is_saldo_akhir' => 'boolean',
    ];
}
