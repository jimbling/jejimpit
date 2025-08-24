<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranJimpitan extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_jimpitan';

    protected $fillable = [
        'tanggal',
        'jumlah',
        'kategori_id',
        'uraian',
        'user_id',
        'locked',
        'alasan_hapus',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'integer',
        'locked'  => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPengeluaran::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
