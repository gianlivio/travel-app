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
        Schema::table('tappe', function (Blueprint $table) {
            $table->string('meta')->nullable()->after('descrizione');  // Aggiungi la colonna meta
        });
    }
    
    public function down()
    {
        Schema::table('tappe', function (Blueprint $table) {
            $table->dropColumn('meta');  // Rimuovi la colonna meta in caso di rollback
        });
    }
};
