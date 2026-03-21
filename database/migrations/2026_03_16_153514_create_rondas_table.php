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
        Schema::create('rondas', function (Blueprint $table) {
            $table->id('id_ronda');
            $table->foreignId('id_kk')->constrained('kepala_keluargas')->references('id_kk');
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Tanpa Keterangan'])->default('Hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rondas');
    }
};
