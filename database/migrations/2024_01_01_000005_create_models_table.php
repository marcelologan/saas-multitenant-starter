<?php
// database/migrations/2024_01_01_000005_create_models_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('category_id');
            $table->uuid('user_id');
            $table->string('name');
            $table->string('reference')->unique();
            $table->text('description')->nullable();
            $table->string('collection')->nullable();
            $table->string('technical_drawing')->nullable(); // path to file
            $table->enum('status', ['draft', 'complete', 'active', 'inactive'])->default('draft');
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->timestamps();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            
            $table->index(['tenant_id', 'status']);
            $table->index(['category_id', 'status']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};