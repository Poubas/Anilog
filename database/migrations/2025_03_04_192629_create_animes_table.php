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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('mal_id')->unique();
            $table->string('title');
            $table->string('image_url');
            $table->timestamps();
        });

        Schema::create('anime_list_anime', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_list_id')->constrained()->onDelete('cascade');
            $table->foreignId('mal_id')->constrained('animes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_list_anime');
        Schema::dropIfExists('animes');
    }
};
