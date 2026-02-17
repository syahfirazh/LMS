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
    Schema::create('kelas_mahasiswa', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();
    $table->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
    $table->integer('absen')->default(0);
    $table->integer('tugas')->default(0);
    $table->integer('uts')->default(0);
    $table->integer('uas')->default(0);
    $table->timestamps();

    $table->unique(['kelas_id', 'mahasiswa_id']);
});

}


    public function down(): void
    {
        Schema::dropIfExists('kelas_mahasiswa');
    }
};
