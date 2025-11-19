<?php
// database/migrations/2024_01_01_000010_create_sizes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('name'); // Pequeno, Médio, Grande
            $table->string('abbreviation'); // P, M, G, GG
            $table->integer('order_sequence'); // para ordenação
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->unique(['tenant_id', 'abbreviation']);
            $table->index(['tenant_id', 'status', 'order_sequence']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};