<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
        Schema::table('submission_messages', function (Blueprint $table) {
            // Cek apakah kolom image belum ada, baru dibuat
            if (!Schema::hasColumn('submission_messages', 'image')) {
                $table->string('image')->nullable()->after('body');
            }
            
            // Cek apakah kolom voice belum ada, baru dibuat
            if (!Schema::hasColumn('submission_messages', 'voice')) {
                $table->string('voice')->nullable()->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('submission_messages', function (Blueprint $table) {
            if (Schema::hasColumn('submission_messages', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('submission_messages', 'voice')) {
                $table->dropColumn('voice');
            }
        });
    }
};