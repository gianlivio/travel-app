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
            $table->date('data_inizio')->nullable();
            $table->date('data_fine')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->dropColumn(['data_inizio', 'data_fine']);
        });
    }
};
