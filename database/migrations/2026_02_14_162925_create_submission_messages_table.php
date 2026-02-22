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
        if (!Schema::hasTable('submission_messages')) {
            Schema::create('submission_messages', function (Blueprint $table) {
                $table->id();
                // Relasi ke tabel submissions (cascade: jika submission dihapus, chat ikut hapus)
                $table->foreignId('submission_id')->constrained()->onDelete('cascade');
                
                // Identitas pengirim
                $table->enum('from', ['dosen', 'mahasiswa']);
                
                // Konten Pesan
                $table->text('body')->nullable();
                
                // Kolom Media (Disesuaikan penamaannya agar rapi)
                $table->string('image_path')->nullable(); 
                $table->string('voice_path')->nullable(); 
                
                // Status Baca (Penting untuk notifikasi angka merah di Sidebar)
                $table->boolean('is_read')->default(false); 
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_messages');
    }
};