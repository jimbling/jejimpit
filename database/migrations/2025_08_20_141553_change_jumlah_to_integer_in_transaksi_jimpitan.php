<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_jimpitan', function (Blueprint $table) {
            $table->unsignedBigInteger('jumlah')->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_jimpitan', function (Blueprint $table) {
            $table->decimal('jumlah', 12, 2)->change();
        });
    }
};
