<?php
// database/migrations/2024_01_01_000014_create_operations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('operational_sequence_id');
            $table->string('operation_name');
            $table->string('machine')->nullable();
            $table->decimal('total_time', 8, 2)->nullable(); // minutos
            $table->integer('time_samples')->nullable();
            $table->decimal('average_time', 8, 2)->nullable(); // minutos
            $table->decimal('rhythm_evaluation', 5, 2)->nullable(); // percentual
            $table->decimal('normal_time', 8, 2)->nullable(); // minutos
            $table->decimal('tolerance', 5, 2)->nullable(); // percentual
            $table->decimal('standard_time', 8, 2)->nullable(); // minutos
            $table->integer('daily_target')->nullable(); // peças por dia
            $table->integer('order_sequence'); // ordem na sequência
            $table->timestamps();
            
            $table->foreign('operational_sequence_id')->references('id')->on('operational_sequences')->onDelete('cascade');
            $table->index(['operational_sequence_id', 'order_sequence']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};