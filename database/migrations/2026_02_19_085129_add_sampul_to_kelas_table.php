<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    // Hanya tambah kolom JIKA kolom 'sampul' belum ada
    if (!Schema::hasColumn('kelas', 'sampul')) {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('sampul')->nullable()->after('ruangan');
        });
    }
}

public function down(): void
{
    if (Schema::hasColumn('kelas', 'sampul')) {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('sampul');
        });
    }
}
};