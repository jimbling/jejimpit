<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaQueue extends Model
{
    use HasFactory;

    protected $table = 'wa_queue';

    protected $fillable = [
        'transaksi_id',
        'warga_id',
        'message',
        'status',
        'scheduled_at',
        'is_scheduled',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // Relasi ke TransaksiJimpitan
    public function transaksi()
    {
        return $this->belongsTo(TransaksiJimpitan::class);
    }

    // Relasi ke Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
