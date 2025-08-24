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
        Schema::create('pengeluaran_jimpitan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('kategori_id'); // relasi ke kategori_pengeluaran
            $table->string('uraian')->nullable();      // detail pengeluaran
            $table->unsignedBigInteger('user_id');     // pencatat transaksi
            $table->boolean('locked')->default(false);
            $table->string('alasan_hapus')->nullable();
            $table->timestamps();

            // Foreign key (opsional, bisa disesuaikan dengan kebutuhan)
            $table->foreign('kategori_id')->references('id')->on('kategori_pengeluaran')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_jimpitan');
    }
};
