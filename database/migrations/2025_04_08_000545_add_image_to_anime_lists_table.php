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
        Schema::table('anime_lists', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->dropColumn('image_url'); // Remove the old column if it exists
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anime_lists', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->string('image_url')->nullable(); // Restore the old column
        });
    }
};
