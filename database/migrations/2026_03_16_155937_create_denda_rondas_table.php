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
        Schema::create('denda_rondas', function (Blueprint $table) {
            $table->id('id_denda');
            $table->foreignId('id_kk')->constrained('kepala_keluargas')->references('id_kk');
            $table->string('deskripsi');
            $table->decimal('jumlah', 15, 2)->default(20000);
            $table->enum('status_pembayaran', ['Belum Bayar', 'Lunas'])->default('Belum Bayar');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda_rondas');
    }
};
