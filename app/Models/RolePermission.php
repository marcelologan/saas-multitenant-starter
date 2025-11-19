<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RolePermission extends Model
{
    use HasUuids;

    protected $fillable = [
        'tenant_id',
        'role_id',
        'permission_id',
        'is_granted',
        'conditions',
    ];

    protected $casts = [
        'is_granted' => 'boolean',
        'conditions' => 'array', // Para JSON
    ];

    /**
     * Relacionamento com Tenant
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Relacionamento com Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relacionamento com Permission
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * Scope para permissões concedidas
     */
    public function scopeGranted($query)
    {
        return $query->where('is_granted', true);
    }

    /**
     * Scope para permissões negadas
     */
    public function scopeDenied($query)
    {
        return $query->where('is_granted', false);
    }

    /**
     * Scope por tenant
     */
    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Scope por role
     */
    public function scopeByRole($query, $roleId)
    {
        return $query->where('role_id', $roleId);
    }

    /**
     * Scope por permission
     */
    public function scopeByPermission($query, $permissionId)
    {
        return $query->where('permission_id', $permissionId);
    }

    /**
     * Verificar se a permissão tem condições específicas
     */
    public function hasConditions(): bool
    {
        return !empty($this->conditions);
    }

    /**
     * Verificar se atende às condições (para implementação futura)
     */
    public function meetsConditions(array $context = []): bool
    {
        if (!$this->hasConditions()) {
            return true;
        }

        // Aqui você pode implementar lógica de condições
        // Por exemplo: verificar horário, IP, etc.
        
        return true; // Por enquanto sempre true
    }
}