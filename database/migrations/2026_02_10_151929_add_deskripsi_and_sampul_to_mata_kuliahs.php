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
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        $table->text('deskripsi')->nullable()->after('sks');
        $table->string('sampul')->nullable()->after('deskripsi');
    });
}

public function down()
{
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        $table->dropColumn(['deskripsi', 'sampul']);
    });
}
};
