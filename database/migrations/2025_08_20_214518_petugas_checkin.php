<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // petugas
            $table->date('tanggal'); // tanggal check-in
            $table->unsignedInteger('jumlah_transaksi')->default(0); // jumlah transaksi malam itu
            $table->timestamps();

            $table->unique(['user_id', 'tanggal']); // mencegah double checkin di hari yang sama
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
