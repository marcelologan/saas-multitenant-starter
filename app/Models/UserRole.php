<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserRole extends Model
{
    use HasUuids;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'role_id',
        'assigned_at',
        'expires_at',
        'assigned_by',
        'is_active',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento com User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relacionamento com quem atribuiu
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Scope para roles ativas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para roles não expiradas
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Verificar se tem permissão específica
     */
    public function hasPermission($permissionSlug): bool
    {
        return $this->activeRoles()
            ->whereHas('rolePermissions', function ($query) use ($permissionSlug) {
                $query->where('is_granted', true)
                    ->whereHas('permission', function ($q) use ($permissionSlug) {
                        $q->where('slug', $permissionSlug)
                            ->where('is_active', true);
                    });
            })->exists();
    }

    /**
     * Verificar permissão por módulo e ação
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
     * Obter todas as permissões do usuário
     */
    public function getAllPermissions()
    {
        return Permission::whereHas('rolePermissions', function ($query) {
            $query->where('is_granted', true)
                ->whereIn('role_id', $this->activeRoles()->pluck('id'));
        })->where('is_active', true)->get();
    }
}
