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
        // Check if the column already exists
        if (!Schema::hasColumn('tappe', 'viaggio_id')) {
            Schema::table('tappe', function (Blueprint $table) {
                $table->foreignId('viaggio_id')->constrained()->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        // Check if the column exists before trying to remove it
        if (Schema::hasColumn('tappe', 'viaggio_id')) {
            Schema::table('tappe', function (Blueprint $table) {
                $table->dropForeign(['viaggio_id']);
                $table->dropColumn('viaggio_id');
            });
        }
    }
};
