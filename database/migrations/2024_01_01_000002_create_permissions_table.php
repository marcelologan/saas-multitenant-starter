<?php
// database/migrations/2024_01_01_000002_create_permissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description');
            $table->string('resource'); // models, production, reports, users
            $table->string('action'); // create, read, update, delete, manage
            $table->enum('role', ['admin', 'manager', 'operator']);
            $table->timestamps();
            
            $table->unique(['resource', 'action', 'role']);
            $table->index(['role', 'resource']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};