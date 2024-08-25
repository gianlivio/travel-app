<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->string('meta')->after('titolo');
            $table->integer('durata')->after('meta');
            $table->string('periodo')->after('durata');
            $table->text('dettagli')->nullable()->after('periodo');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->dropColumn(['meta', 'durata', 'periodo', 'dettagli', 'image']);
        });
    }
};