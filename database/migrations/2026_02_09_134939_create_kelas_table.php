<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
   Schema::create('kelas', function (Blueprint $table) {
    $table->id();

    $table->foreignId('dosen_id')
          ->constrained('dosens')
          ->cascadeOnDelete();

    $table->foreignId('mata_kuliah_id')
          ->constrained('mata_kuliahs')
          ->cascadeOnDelete();

    $table->string('kode_kelas');
    $table->string('hari');
    $table->time('jam_mulai');
    $table->time('jam_selesai');
    $table->string('ruangan')->nullable();
    $table->string('sampul')->nullable();
    $table->text('deskripsi')->nullable();

    $table->timestamps();
});


}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
