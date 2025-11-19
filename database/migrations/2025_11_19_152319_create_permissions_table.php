<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id')->nullable();
            $table->string('module', 100)->index();
            $table->string('action', 100);
            $table->string('name', 150);
            $table->string('slug', 150)->index();
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false)->index();
            $table->boolean('is_active')->default(true);
            $table->string('group', 100)->nullable()->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->index(['tenant_id', 'module']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};