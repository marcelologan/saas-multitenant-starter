<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'company_name',
        'trade_name',
        'cnpj',
        'address',
        'complement',
        'neighborhood',
        'city',
        'state',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Usuários do tenant
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Assinatura ativa do tenant
     */
    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->whereIn('status', ['trial', 'active'])
            ->latest();
    }

    /**
     * Todas as assinaturas do tenant
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Usuário administrador do tenant
     */
    public function admin(): HasOne
    {
        return $this->hasOne(User::class)->where('role', 'admin');
    }

    /**
     * Verificar se o tenant está ativo
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Verificar se tem assinatura ativa
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Formatar CNPJ
     */
    public function getFormattedCnpjAttribute(): string
    {
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $this->cnpj);
    }
}