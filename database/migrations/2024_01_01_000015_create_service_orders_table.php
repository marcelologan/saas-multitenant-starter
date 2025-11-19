<?php
// database/migrations/2024_01_01_000015_create_service_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('model_id');
            $table->uuid('user_id'); // usuário que criou a OS
            $table->string('os_number')->unique();
            $table->enum('type', ['creation', 'cutting', 'sewing']);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('model_id')->references('id')->on('models')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            
            $table->index(['tenant_id', 'status', 'type']);
            $table->index(['model_id', 'status']);
            $table->index(['user_id']);
            $table->index(['due_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};