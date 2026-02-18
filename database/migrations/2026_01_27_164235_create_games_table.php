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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('developer');
            $table->string('distributor');
            $table->text('description');
            $table->string('game_mode');
            $table->string('cover_image')->nullable();
            $table->string('classification');
            $table->string('genre');
            $table->string('platform');
            $table->year('release_year');
            $table->decimal('rating', 3, 1)->nullable();
            $table->decimal('average_rating');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
