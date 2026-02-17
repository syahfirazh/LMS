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
    Schema::create('submissions', function (Blueprint $table) {
        $table->id();
        $table->integer('nilai')->nullable();
        $table->text('feedback')->nullable();
        $table->timestamp('submitted_at')->nullable();


        $table->unsignedBigInteger('assignment_id');
        $table->unsignedBigInteger('mahasiswa_id'); // TANPA FK dulu

        $table->string('file_path')->nullable();
        $table->timestamps();

        $table->foreign('assignment_id')
              ->references('id')
              ->on('assignments')
              ->onDelete('cascade');
    }); 
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
