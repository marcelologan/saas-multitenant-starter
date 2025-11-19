<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Permission extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'module',
        'action',
        'name',
        'slug',
        'description',
        'is_system',
        'is_active',
        'group',
        'sort_order',
    ];

    protected $casts = [
        'is_system' => 'boolean',
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
     * Relacionamento com Roles (many-to-many)
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
                    ->withPivot(['is_granted', 'conditions'])
                    ->withTimestamps();
    }

    /**
     * Role Permissions diretos
     */
    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }

    /**
     * Roles que têm esta permissão concedida
     */
    public function grantedRoles(): BelongsToMany
    {
        return $this->roles()->wherePivot('is_granted', true);
    }

    /**
     * Roles que têm esta permissão negada
     */
    public function deniedRoles(): BelongsToMany
    {
        return $this->roles()->wherePivot('is_granted', false);
    }

    /**
     * Scope para permissions ativas
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
     * Scope por módulo
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope por grupo
     */
    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope para permissions não do sistema (editáveis)
     */
    public function scopeEditable($query)
    {
        return $query->where('is_system', false);
    }

    /**
     * Formatar nome completo da permissão
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->module}.{$this->action}";
    }
}