<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_jimpitan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('jumlah', 12, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['warga_id', 'tanggal']); // untuk laporan bulanan/per warga
            $table->index(['user_id', 'tanggal']);  // untuk laporan per petugas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_jimpitan');
    }
};
