<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jumlah_transaksi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke user (petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke transaksi jimpitan yang terjadi pada tanggal check-in ini
    public function transaksi()
    {
        return $this->hasMany(TransaksiJimpitan::class, 'user_id', 'user_id')
            ->whereDate('tanggal', $this->tanggal);
    }
}
