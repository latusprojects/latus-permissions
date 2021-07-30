<?php


namespace Latus\Permissions\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Repositories\EloquentRepository;
use Latus\Permissions\Repositories\Contracts\RoleRepository as RoleRepositoryContract;

class RoleRepository extends EloquentRepository implements RoleRepositoryContract
{

    public function relatedModel(): Model
    {
        return new Role();
    }

    public function delete(Role $role)
    {
        $role->delete();
    }

    public function findByName(string $name): Role|null
    {
        return $this->relatedModel()->where('name', $name)->first();
    }

    public function addPermission(Role $role, Permission $permission)
    {
        $role->permissions()->attach($permission->id);
    }

    public function removePermission(Role $role, Permission $permission): int
    {
        return $role->permissions()->detach($permission->id);
    }

    public function getPermissions(Role $role): Collection
    {
        return $role->permissions()->get();
    }

    public function getResolvedPermissions(Role $role): Collection
    {
        return $role->resolvePermissions();
    }

    public function hasPermission(Role $role, Permission $permission): bool
    {
        return $role->resolvePermissions()->contains($permission);
    }

    public function addUser(Role $role, User $user)
    {
        $role->users()->attach($user->id);
    }

    public function removeUser(Role $role, User $user): int
    {
        return $role->users()->detach($user->id);
    }

    public function getUsers(Role $role): Collection
    {
        return $role->users()->get();
    }

    public function hasUser(Role $role, User $user): bool
    {
        return $role->users()->where('user_id', $user->id)->exists();
    }
}