<?php
// database/migrations/2024_01_01_000009_create_material_colors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_colors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('model_material_id');
            $table->uuid('color_id');
            $table->decimal('additional_cost', 8, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('model_material_id')->references('id')->on('model_materials')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('restrict');
            
            $table->unique(['model_material_id', 'color_id']);
            $table->index(['model_material_id']);
            $table->index(['color_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_colors');
    }
};