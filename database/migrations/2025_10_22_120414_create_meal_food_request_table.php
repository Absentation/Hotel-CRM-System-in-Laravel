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
        Schema::create('meal_food_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('request_id')->constrained('food_requests')->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_food_request');
    }
};
