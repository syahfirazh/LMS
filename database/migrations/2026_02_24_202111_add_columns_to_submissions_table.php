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
    Schema::table('submissions', function (Blueprint $table) {
        $table->text('text_submission')->nullable()->after('file_path');
        $table->string('voice_submission')->nullable()->after('text_submission');
    });
}
public function down(): void
{
    Schema::table('submissions', function (Blueprint $table) {
        $table->dropColumn(['text_submission', 'voice_submission']);
    });
}
    
};
