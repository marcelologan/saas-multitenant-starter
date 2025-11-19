<?php
// database/migrations/2024_01_01_000006_create_materials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('name');
            $table->string('supplier')->nullable();
            $table->decimal('unit_price', 8, 2);
            $table->string('unit_measure'); // metro, unidade, kg, etc
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->index(['tenant_id', 'status']);
            $table->index(['supplier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};