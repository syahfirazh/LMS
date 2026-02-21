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
        Schema::create('attendances', function (Blueprint $table) {
    $table->id();

    $table->foreignId('course_session_id')
        ->constrained('course_sessions')
        ->cascadeOnDelete();

    $table->foreignId('mahasiswa_id')
        ->constrained('mahasiswas')
        ->cascadeOnDelete();

    $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
    $table->timestamp('waktu_absen')->nullable();

    $table->unique(['course_session_id', 'mahasiswa_id']);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
