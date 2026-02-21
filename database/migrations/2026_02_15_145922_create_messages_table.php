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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();

        $table->string('sender_type');   // dosen / mahasiswa
        $table->unsignedBigInteger('sender_id');

        $table->string('receiver_type'); // dosen / mahasiswa
        $table->unsignedBigInteger('receiver_id');

        $table->text('body')->nullable();
        $table->string('image_path')->nullable();
        $table->boolean('is_read')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
