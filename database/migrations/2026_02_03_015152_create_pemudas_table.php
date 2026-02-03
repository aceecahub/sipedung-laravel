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
        Schema::create('pemudas', function (Blueprint $table) {
            $table->id('id_pemuda');
            $table->foreignId('id_warga')->constrained('wargas')->references('id_warga');
            $table->enum('jabatan', ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Anggota']);
            $table->enum('status', ['Aktif', 'Nonaktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemudas');
    }
};
