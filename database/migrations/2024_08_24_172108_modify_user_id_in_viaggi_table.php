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
            $table->unsignedBigInteger('user_id')->nullable()->change(); 
        });
    }

    public function down()
    {
        Schema::table('viaggi', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
