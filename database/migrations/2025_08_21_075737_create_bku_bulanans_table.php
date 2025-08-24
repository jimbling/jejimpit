<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bku_bulanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('bulan');        // 1-12
            $table->unsignedSmallInteger('tahun');       // Tahun
            $table->bigInteger('saldo_awal')->default(0);
            $table->bigInteger('total_penerimaan')->default(0);
            $table->bigInteger('saldo_akhir')->default(0);
            $table->boolean('locked')->default(false);   // Lock setelah tutup bulan
            $table->string('alasan_hapus')->nullable(); // Alasan hapus jika locked
            $table->timestamps();

            $table->unique(['bulan', 'tahun']);          // Satu BKU per bulan unik
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bku_bulanan');
    }
};
