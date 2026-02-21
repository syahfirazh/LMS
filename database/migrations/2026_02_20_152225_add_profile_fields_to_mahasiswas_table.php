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
    Schema::table('mahasiswas', function (Blueprint $table) {
        $table->string('prodi')->nullable();
        $table->string('fakultas')->nullable();
        $table->integer('semester')->nullable();
        $table->string('status')->default('Mahasiswa Aktif');
        $table->year('tahun_masuk')->nullable();
        $table->string('email_kampus')->nullable();
        $table->string('email_pribadi')->nullable();
        $table->string('no_hp')->nullable();
        $table->string('foto')->nullable();
    });
}

public function down(): void
{
    Schema::table('mahasiswas', function (Blueprint $table) {
        $table->dropColumn([
            'prodi',
            'fakultas',
            'semester',
            'status',
            'tahun_masuk',
            'email_kampus',
            'email_pribadi',
            'no_hp',
            'foto'
        ]);
    });
}
};
