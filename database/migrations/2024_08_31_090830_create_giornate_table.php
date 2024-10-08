<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('giornate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viaggio_id')->constrained('viaggi')->onDelete('cascade');
            $table->date('data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giornate');
    }
};