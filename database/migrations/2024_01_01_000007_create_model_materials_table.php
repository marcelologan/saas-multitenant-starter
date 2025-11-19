<?php
// database/migrations/2024_01_01_000007_create_model_materials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('model_id');
            $table->uuid('material_id');
            $table->decimal('quantity', 8, 3);
            $table->decimal('unit_cost', 8, 2);
            $table->text('observations')->nullable();
            $table->timestamps();
            
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('restrict');
            
            $table->unique(['model_id', 'material_id']);
            $table->index(['model_id']);
            $table->index(['material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_materials');
    }
};