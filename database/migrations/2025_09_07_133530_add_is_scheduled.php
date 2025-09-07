<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wa_queue', function (Blueprint $table) {
            $table->boolean('is_scheduled')->default(false)->after('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::table('wa_queue', function (Blueprint $table) {
            $table->dropColumn('is_scheduled');
        });
    }
};
