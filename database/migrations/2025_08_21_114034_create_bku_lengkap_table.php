<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bku_lengkap', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('no');
            $table->date('tanggal');
            $table->string('uraian');
            $table->bigInteger('dana_masuk')->default(0);
            $table->bigInteger('jumlah')->default(0);

            // tambahan opsional
            $table->bigInteger('saldo_awal')->default(0);
            $table->boolean('is_saldo_awal')->default(false);
            $table->boolean('is_tutup_tahun')->default(false);
            $table->boolean('locked')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bku_lengkap');
    }
};
