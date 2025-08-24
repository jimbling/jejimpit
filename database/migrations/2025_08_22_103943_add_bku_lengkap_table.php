<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bku_lengkap', function (Blueprint $table) {
            // rename jumlah → saldo (kalau ada data lama, otomatis ikut dipindahkan)
            if (Schema::hasColumn('bku_lengkap', 'jumlah')) {
                $table->renameColumn('jumlah', 'saldo');
            }

            // tambahkan kolom baru bila belum ada
            if (!Schema::hasColumn('bku_lengkap', 'dana_keluar')) {
                $table->integer('dana_keluar')->nullable()->after('dana_masuk');
            }

            if (!Schema::hasColumn('bku_lengkap', 'is_saldo_akhir')) {
                $table->boolean('is_saldo_akhir')->default(false)->after('is_saldo_awal');
            }

            // hapus kolom yang tidak diperlukan lagi
            if (Schema::hasColumn('bku_lengkap', 'is_tutup_tahun')) {
                $table->dropColumn('is_tutup_tahun');
            }

            if (!Schema::hasColumn('bku_lengkap', 'locked')) {
                $table->boolean('locked')->default(false)->after('is_saldo_akhir');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bku_lengkap', function (Blueprint $table) {
            // rollback perubahan
            if (Schema::hasColumn('bku_lengkap', 'saldo')) {
                $table->renameColumn('saldo', 'jumlah');
            }

            if (Schema::hasColumn('bku_lengkap', 'dana_keluar')) {
                $table->dropColumn('dana_keluar');
            }

            if (Schema::hasColumn('bku_lengkap', 'is_saldo_akhir')) {
                $table->dropColumn('is_saldo_akhir');
            }

            if (!Schema::hasColumn('bku_lengkap', 'is_tutup_tahun')) {
                $table->boolean('is_tutup_tahun')->default(false);
            }

            if (Schema::hasColumn('bku_lengkap', 'locked')) {
                $table->dropColumn('locked');
            }
        });
    }
};
