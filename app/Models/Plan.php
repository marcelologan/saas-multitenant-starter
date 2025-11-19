<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'billing_cycle',
        'features',
        'max_users',
        'max_storage_gb',
        'max_products',
        'is_active',
        'is_popular',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'max_users' => 'integer',
        'max_storage_gb' => 'integer',
        'max_products' => 'integer',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'billing_cycle' => 'string',
    ];

    /**
     * Assinaturas deste plano
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Verificar se o plano está ativo
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Preço formatado
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'R\$ ' . number_format($this->price, 2, ',', '.');
    }

    /**
     * Scope para planos ativos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para planos populares
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }
}