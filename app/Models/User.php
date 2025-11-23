<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * Relacionamento com Roles (many-to-many)
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withPivot(['assigned_at', 'expires_at', 'assigned_by', 'is_active'])
            ->withTimestamps();
    }

    /**
     * User Roles diretos
     */
    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    /**
     * Roles ativas do usuário
     */
    public function activeRoles(): BelongsToMany
    {
        return $this->roles()
            ->wherePivot('is_active', true)
            ->where(function ($query) {
                $query->whereNull('user_roles.expires_at')
                    ->orWhere('user_roles.expires_at', '>', now());
            });
    }

    /**
     * Verificar se usuário tem role específica
     */
    public function hasRole($roleSlug): bool
    {
        return $this->activeRoles()->where('slug', $roleSlug)->exists();
    }

    /**
     * Verificar se é admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin-empresa');
    }

    /**
     * Verificar se é gerente
     */
    public function isManager(): bool
    {
        return $this->hasRole('gerente');
    }

    /**
     * Verificar se é funcionário
     */
    public function isOperator(): bool
    {
        return $this->hasRole('funcionario');
    }

    /**
     * Verificar se está ativo
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Verificar se tem permissão específica - CORRIGIDO
     */
    public function hasPermission($permissionSlug): bool
    {
        $roleIds = $this->activeRoles()->pluck('roles.id');

        return RolePermission::whereIn('role_id', $roleIds)
            ->where('is_granted', true)
            ->whereHas('permission', function ($query) use ($permissionSlug) {
                $query->where('slug', $permissionSlug)
                    ->where('is_active', true);
            })
            ->exists();
    }

    /**
     * Verificar permissão por módulo e ação - CORRIGIDO
     */
    public function hasModulePermission(string $module, string $action): bool
    {
        return $this->activeRoles()
            ->whereHas('rolePermissions', function ($query) use ($module, $action) {
                $query->where('is_granted', true)
                    ->whereHas('permission', function ($q) use ($module, $action) {
                        $q->where('module', $module)
                            ->where('action', $action)
                            ->where('is_active', true);
                    });
            })->exists();
    }

    /**
     * Obter todas as permissões do usuário - CORRIGIDO
     */
    public function getAllPermissions()
    {
        $roleIds = $this->activeRoles()->pluck('roles.id');

        return Permission::whereHas('rolePermissions', function ($query) use ($roleIds) {
            $query->where('is_granted', true)
                ->whereIn('role_id', $roleIds);
        })->where('is_active', true)->get();
    }

    /**
     * Verificar se tem qualquer uma das permissões
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verificar se tem todas as permissões
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
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
        return $query->whereHas('activeRoles', function ($q) use ($roleSlug) {
            $q->where('slug', $roleSlug);
        });
    }

    /**
     * Scope por tenant
     */
    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
