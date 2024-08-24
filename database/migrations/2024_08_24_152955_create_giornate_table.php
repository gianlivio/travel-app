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
        Schema::create('giornate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viaggio_id')->constrained()->onDelete('cascade');
            $table->date('data');
            $table->text('descrizione')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('giornate');
    }
};
