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
    Schema::table('course_sessions', function (Blueprint $table) {
        $table->date('tanggal')->nullable()->after('urutan');
        $table->time('jam_mulai')->nullable()->after('tanggal');
        $table->time('jam_selesai')->nullable()->after('jam_mulai');
    });
}

public function down(): void
{
    Schema::table('course_sessions', function (Blueprint $table) {
        $table->dropColumn(['tanggal', 'jam_mulai', 'jam_selesai']);
    });
}
};
