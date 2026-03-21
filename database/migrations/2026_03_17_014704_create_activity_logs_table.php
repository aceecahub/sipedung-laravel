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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('id_activity');
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('action'); // e.g., 'created', 'updated', 'deleted'
            $table->string('model_type')->nullable(); // e.g., 'App\Models\Warga'
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('description'); // e.g., 'Menambahkan warga Budi'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
