<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanMingguan extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_mingguan';

    protected $fillable = [
        'minggu',
        'bulan',
        'tahun',
        'total',
        'locked',
        'alasan_hapus',
    ];

    protected $casts = [
        'locked' => 'boolean',
        'total'  => 'integer',
    ];
}
