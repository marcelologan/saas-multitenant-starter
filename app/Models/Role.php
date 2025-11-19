<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Role extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'description',
        'is_system',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento com Tenant
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Relacionamento com Users (many-to-many)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')
                    ->withPivot(['assigned_at', 'expires_at', 'assigned_by', 'is_active'])
                    ->withTimestamps();
    }

    /**
     * Relacionamento com Permissions (many-to-many)
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
                    ->withPivot(['is_granted', 'conditions'])
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
     * Role Permissions diretos
     */
    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }

    /**
     * Permissões concedidas
     */
    public function grantedPermissions(): BelongsToMany
    {
        return $this->permissions()->wherePivot('is_granted', true);
    }

    /**
     * Permissões negadas
     */
    public function deniedPermissions(): BelongsToMany
    {
        return $this->permissions()->wherePivot('is_granted', false);
    }

    /**
     * Verificar se tem permissão específica
     */
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->grantedPermissions()
                    ->where('slug', $permissionSlug)
                    ->exists();
    }

    /**
     * Verificar se tem permissão por módulo e ação
     */
    public function hasModulePermission(string $module, string $action): bool
    {
        return $this->grantedPermissions()
                    ->where('module', $module)
                    ->where('action', $action)
                    ->exists();
    }

    /**
     * Obter todas as permissões por módulo
     */
    public function getPermissionsByModule(string $module)
    {
        return $this->grantedPermissions()
                    ->where('module', $module)
                    ->get();
    }

    /**
     * Scope para roles ativas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope por tenant
     */
    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Scope para roles não do sistema (editáveis)
     */
    public function scopeEditable($query)
    {
        return $query->where('is_system', false);
    }
}