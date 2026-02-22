<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nidn')->unique()->nullable(); 
            $table->string('email')->unique(); 
            $table->string('password')->nullable(); 
            $table->string('nama');
            $table->string('no_hp')->nullable();
            // Kolom bidang_keahlian SUDAH DIHAPUS
            $table->string('homebase')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('foto')->nullable();
            $table->string('google_id')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};