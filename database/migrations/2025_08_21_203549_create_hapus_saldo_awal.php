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
        Schema::table('bku_lengkap', function (Blueprint $table) {
            if (Schema::hasColumn('bku_lengkap', 'saldo_awal')) {
                $table->dropColumn('saldo_awal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bku_lengkap', function (Blueprint $table) {
            $table->decimal('saldo_awal', 15, 2)->default(0)->after('jumlah');
        });
    }
};
