<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'status',
        'starts_at',
        'ends_at',
        'trial_ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Tenant da assinatura
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Plano da assinatura
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Verificar se está em trial
     */
    public function isOnTrial(): bool
    {
        return $this->status === 'trial' && 
               $this->trial_ends_at && 
               $this->trial_ends_at->isFuture();
    }

    /**
     * Verificar se está ativa
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['trial', 'active']) &&
               ($this->ends_at === null || $this->ends_at->isFuture());
    }

    /**
     * Verificar se expirou
     */
    public function isExpired(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    /**
     * Dias restantes do trial
     */
    public function trialDaysRemaining(): int
    {
        if (!$this->isOnTrial()) {
            return 0;
        }

        return max(0, $this->trial_ends_at->diffInDays(now()));
    }

    /**
     * Dias restantes da assinatura
     */
    public function daysRemaining(): int
    {
        if (!$this->ends_at) {
            return PHP_INT_MAX; // Assinatura sem fim
        }

        return max(0, $this->ends_at->diffInDays(now()));
    }
}