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
        Schema::create('kas_agustus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_warga')->constrained('wargas')->references('id_warga');
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->enum('status_perelek', ['Ada', 'Tidak Ada'])->default('Ada');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_agustuses');
    }
};
