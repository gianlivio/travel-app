<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('viaggi', function (Blueprint $table) {
            $table->id();
            $table->string('titolo');
            $table->string('meta');
            $table->integer('durata');
            // $table->string('periodo'); // Eliminato come richiesto
            $table->text('dettagli')->nullable();
            $table->string('immagine')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('data_inizio')->nullable();
            $table->date('data_fine')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viaggi');
    }
};