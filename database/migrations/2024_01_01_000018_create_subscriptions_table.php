<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ✅ MUDANÇA: UUID em vez de id()
            $table->char('tenant_id', 36);
            $table->foreignId('plan_id')->constrained('plans')->onDelete('restrict');
            $table->enum('status', [
                'trial',
                'active',
                'suspended',
                'canceled',
                'expired'
            ])->default('trial');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('tenant_id');
            $table->index(['tenant_id', 'status']);

            // Foreign key
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
