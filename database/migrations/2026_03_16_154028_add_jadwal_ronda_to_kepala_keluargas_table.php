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
        Schema::table('kepala_keluargas', function (Blueprint $table) {
            $table->enum('kelompok_ronda', ['1', '2', '3', '4', '5', '6', '7'])->nullable()->after('pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kepala_keluargas', function (Blueprint $table) {
            $table->dropColumn('kelompok_ronda');
        });
    }
};
