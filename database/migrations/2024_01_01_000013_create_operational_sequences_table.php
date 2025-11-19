<?php
// database/migrations/2024_01_01_000013_create_operational_sequences_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operational_sequences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('model_id');
            $table->decimal('standard_time_model', 8, 2)->nullable(); // tempo em minutos
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
            $table->index(['model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_sequences');
    }
};