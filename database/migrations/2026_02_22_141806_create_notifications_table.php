<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('user_type'); // 'dosen' atau 'mahasiswa'
            $table->unsignedBigInteger('user_id'); 
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Isi notifikasi
            $table->string('type')->default('info'); // 'info', 'warning', 'success' (untuk warna icon)
            $table->boolean('is_read')->default(false); // Status sudah dibaca/belum
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};