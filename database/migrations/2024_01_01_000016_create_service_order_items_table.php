<?php
// database/migrations/2024_01_01_000016_create_service_order_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('service_order_id');
            $table->uuid('color_id');
            $table->uuid('size_id');
            $table->integer('quantity');
            $table->integer('completed_quantity')->default(0);
            $table->timestamps();
            
            $table->foreign('service_order_id')->references('id')->on('service_orders')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('restrict');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('restrict');
            
            $table->unique(['service_order_id', 'color_id', 'size_id']);
            $table->index(['service_order_id']);
            $table->index(['color_id']);
            $table->index(['size_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_order_items');
    }
};