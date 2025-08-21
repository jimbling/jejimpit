<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unik', 20)->unique();
            $table->string('nama_kk', 100);
            $table->string('alamat', 255);
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('no_rumah', 10)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index('kode_unik'); // mempercepat pencarian scan QR
            $table->index(['rt', 'rw']); // untuk filter wilayah
        });
    }

    public function down()
    {
        Schema::dropIfExists('warga');
    }
};
