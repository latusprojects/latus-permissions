<?php


namespace Latus\Permissions\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Permission;
use Latus\Repositories\EloquentRepository;
use Latus\Permissions\Repositories\Contracts\PermissionRepository as PermissionRepositoryContract;

class PermissionRepository extends EloquentRepository implements PermissionRepositoryContract
{

    public function relatedModel(): Model
    {
        return new Permission();
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
    }

    public function findByName(string $name): Permission|null
    {
        return $this->relatedModel()->where('name', $name)->first();
    }

    public function grantTo(Permission $permission, Permissible $permissible)
    {
        $permissible->permissions()->attach($permission->id);
    }

    public function revokeFrom(Permission $permission, Permissible $permissible): int
    {
        return $permissible->permissions()->detach($permission->id);
    }

    public function isGrantedTo(Permission $permission, Permissible $permissible, bool $resolvePermissions = true): bool
    {
        if ($resolvePermissions) {
            return $permissible->resolvePermissions()->contains($permission);
        }
        return $permissible->permissions()->where('permission_id', $permission->id)->exists();
    }

    public function getRoles(Permission $permission): Collection
    {
        return $permission->roles()->get();
    }

    public function getUsers(Permission $permission): Collection
    {
        return $permission->users()->get();
    }
}