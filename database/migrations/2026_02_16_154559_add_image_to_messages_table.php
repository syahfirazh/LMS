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
    Schema::table('messages', function (Blueprint $table) {

        if (!Schema::hasColumn('messages', 'image_path')) {
            $table->string('image_path')->nullable();
        }

        if (!Schema::hasColumn('messages', 'is_read')) {
            $table->boolean('is_read')->default(false);
        }

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }
};
