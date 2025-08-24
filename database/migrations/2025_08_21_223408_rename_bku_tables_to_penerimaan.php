<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi (rename tabel).
     */
    public function up(): void
    {
        Schema::rename('bku_mingguan', 'penerimaan_mingguan');
        Schema::rename('bku_bulanan', 'penerimaan_bulanan');
    }

    /**
     * Rollback migrasi (balik ke nama awal).
     */
    public function down(): void
    {
        Schema::rename('penerimaan_mingguan', 'bku_mingguan');
        Schema::rename('penerimaan_bulanan', 'bku_bulanan');
    }
};
