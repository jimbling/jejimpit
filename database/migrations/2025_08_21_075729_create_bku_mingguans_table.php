<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bku_mingguan', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('minggu');      // Minggu ke-n dalam bulan
            $table->unsignedTinyInteger('bulan');       // 1-12
            $table->unsignedSmallInteger('tahun');      // Tahun
            $table->bigInteger('total');                // Total penerimaan minggu ini
            $table->boolean('locked')->default(false);  // Lock setelah tutup minggu
            $table->string('alasan_hapus')->nullable(); // Alasan hapus jika locked
            $table->timestamps();

            $table->unique(['minggu', 'bulan', 'tahun']); // Satu BKU per minggu unik
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bku_mingguan');
    }
};
