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
        Schema::table('exams', function (Blueprint $table) {
            // Tambahkan kolom token dan status setelah kolom waktu_selesai
            $table->string('token')->nullable()->after('waktu_selesai');
            $table->enum('status', ['draft', 'published'])->default('draft')->after('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            // Hapus kolom token dan status jika di-rollback
            $table->dropColumn(['token', 'status']);
        });
    }
};