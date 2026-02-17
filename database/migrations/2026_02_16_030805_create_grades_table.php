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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelas_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('mahasiswa_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('tugas')->nullable();
            $table->unsignedTinyInteger('uts')->nullable();
            $table->unsignedTinyInteger('uas')->nullable();
            $table->unsignedTinyInteger('absen')->nullable();

            $table->timestamps();

            $table->unique(['kelas_id', 'mahasiswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
