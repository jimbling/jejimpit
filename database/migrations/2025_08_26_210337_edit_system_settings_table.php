<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('nama_rt')->nullable()->after('kode_pos');
            $table->string('nama_koordinator')->nullable()->after('nama_rt');
            $table->string('nama_dusun')->nullable()->after('nama_koordinator');

            // Hapus kolom yang tidak diperlukan
            $table->dropColumn([
                'kepala_sekolah',
                'nama_sekolah',
                'npsn',
                'alamat_lengkap',
                'tahun_berdiri',
                'jenjang_pendidikan',
                'status_sekolah',
                'kurikulum_berlaku',
                'nip_kepala_sekolah',
            ]);
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            // Tambah kembali kolom lama
            $table->string('kepala_sekolah')->nullable();
            $table->string('nama_sekolah');
            $table->string('npsn')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->year('tahun_berdiri')->nullable();
            $table->string('jenjang_pendidikan')->nullable();
            $table->string('status_sekolah')->nullable();
            $table->string('kurikulum_berlaku')->nullable();
            $table->string('nip_kepala_sekolah')->nullable();

            // Hapus kolom baru
            $table->dropColumn(['nama_rt', 'nama_koordinator', 'nama_dusun']);
        });
    }
};
