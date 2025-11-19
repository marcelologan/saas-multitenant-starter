<?php
// database/migrations/2024_01_01_000012_create_model_colors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_colors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('model_id');
            $table->uuid('color_id');
            $table->timestamps();
            
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('restrict');
            
            $table->unique(['model_id', 'color_id']);
            $table->index(['model_id']);
            $table->index(['color_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_colors');
    }
};