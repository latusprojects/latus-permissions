<?php

namespace Latus\Permissions\Models\Traits;

use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Permissible
{
    public function hasOnePermission(array $names): bool
    {
        $permissions = Permission::whereIn('name', $names)->get();
        if (!$permissions) {
            return false;
        }

        foreach ($permissions as $permission) {
            if ($this->effectivePermissions()->contains($permission)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission(string $name): bool
    {
        $permission = Permission::where('name', strtolower($name))->first();
        if (!$permission) {
            return false;
        }
        return $this->effectivePermissions()->contains($permission);
    }

    public function effectivePermissions(): Collection
    {
        $role_permissions = $this->roles()->with('permissions')->get()->pluck('permissions')->unique()->flatten();
        $user_permissions = $this->permissions()->get();

        return $user_permissions->concat($role_permissions);
    }

    public function primaryRole(): Role
    {
        return $this->roles()->orderBy('level', 'desc')->first();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
