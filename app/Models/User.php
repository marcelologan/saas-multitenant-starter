<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento com Tenant
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Verificar se é admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin-empresa';
    }

    /**
     * Verificar se é gerente
     */
    public function isManager(): bool
    {
        return $this->role === 'gerente';
    }

    /**
     * Verificar se é funcionário
     */
    public function isOperator(): bool
    {
        return $this->role === 'funcionario';
    }

    /**
     * Verificar se está ativo
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Verificar se tem role específica
     */
    public function hasRole($roleSlug): bool
    {
        return $this->role === $roleSlug;
    }

    /**
     * Formatar telefone
     */
    public function getFormattedPhoneAttribute(): string
    {
        if (!$this->phone) return '';

        $phone = preg_replace('/\D/', '', $this->phone);

        if (strlen($phone) === 11) {
            return sprintf(
                '(%s) %s-%s',
                substr($phone, 0, 2),
                substr($phone, 2, 5),
                substr($phone, 7)
            );
        }

        return $this->phone;
    }

    /**
     * Scope para usuários ativos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope por role
     */
    public function scopeByRole($query, $roleSlug)
    {
        return $query->where('role', $roleSlug);
    }
}
