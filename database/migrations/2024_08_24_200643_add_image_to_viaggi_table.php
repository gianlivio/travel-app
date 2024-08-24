<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToViaggiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}