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
        Schema::table('viaggi', function (Blueprint $table) {
            $table->string('image')->nullable(); // Colonna per il percorso dell'immagine
        });
    }

    public function down()
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
