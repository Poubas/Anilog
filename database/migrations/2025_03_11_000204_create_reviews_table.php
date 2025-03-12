<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->boolean('is_positive')->default(true); // true for like, false for dislike
            $table->text('content');
            $table->timestamps();
            
            // Prevent multiple reviews from the same user for the same anime
            $table->unique(['user_id', 'anime_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
