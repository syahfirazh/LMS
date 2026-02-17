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
        $table->foreignId('dosen_id')
              ->after('id')
              ->constrained('dosens')
              ->cascadeOnDelete();
    });
}

public function down()
{
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        $table->dropForeign(['dosen_id']);
        $table->dropColumn('dosen_id');
    });
}
};
