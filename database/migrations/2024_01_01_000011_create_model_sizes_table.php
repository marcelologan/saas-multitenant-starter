<?php
// database/migrations/2024_01_01_000011_create_model_sizes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_sizes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('model_id');
            $table->uuid('size_id');
            $table->timestamps();
            
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('restrict');
            
            $table->unique(['model_id', 'size_id']);
            $table->index(['model_id']);
            $table->index(['size_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_sizes');
    }
};