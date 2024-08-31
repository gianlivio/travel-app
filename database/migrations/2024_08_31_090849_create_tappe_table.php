<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tappe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('giornata_id')->constrained('giornate')->onDelete('cascade');
            $table->string('titolo');
            $table->text('descrizione')->nullable();
            $table->string('immagine')->nullable();
            $table->string('cibo')->nullable();
            $table->string('curiosita')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tappe');
    }
};