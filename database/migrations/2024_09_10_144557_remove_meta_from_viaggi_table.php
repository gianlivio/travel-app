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
        Schema::table('viaggi', function (Blueprint $table) {
            $table->dropColumn('meta'); // Rimuovi la colonna meta
        });
    }

    public function down(): void
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->string('meta'); // Ripristina la colonna meta in caso di rollback
        });
    }
};
