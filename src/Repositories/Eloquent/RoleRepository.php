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
    /**
     * @inheritDoc
     */
    public function relatedModel(): Model
    {
        return new Role();
    }

    /**
     * @inheritDoc
     */
    public function delete(Role $role)
    {
        $role->delete();
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $name): Role|null
    {
        return $this->relatedModel()->where('name', $name)->first();
    }

    /**
     * @inheritDoc
     */
    public function addPermission(Role $role, Permission $permission)
    {
        $role->permissions()->attach($permission->id);
    }

    /**
     * @inheritDoc
     */
    public function removePermission(Role $role, Permission $permission): int
    {
        return $role->permissions()->detach($permission->id);
    }

    /**
     * @inheritDoc
     */
    public function getPermissions(Role $role): Collection
    {
        return $role->permissions()->get();
    }

    /**
     * @inheritDoc
     */
    public function getResolvedPermissions(Role $role): Collection
    {
        return $role->resolvePermissions();
    }

    /**
     * @inheritDoc
     */
    public function hasPermission(Role $role, Permission $permission): bool
    {
        return $role->resolvePermissions()->contains($permission);
    }

    /**
     * @inheritDoc
     */
    public function addUser(Role $role, User $user)
    {
        $role->users()->attach($user->id);
    }

    /**
     * @inheritDoc
     */
    public function removeUser(Role $role, User $user): int
    {
        return $role->users()->detach($user->id);
    }

    /**
     * @inheritDoc
     */
    public function getUsers(Role $role): Collection
    {
        return $role->users()->get();
    }

    /**
     * @inheritDoc
     */
    public function hasUser(Role $role, User $user): bool
    {
        return $role->users()->where('user_id', $user->id)->exists();
    }

    /**
     * @inheritDoc
     */
    public function getChildren(Role $role): Collection
    {
        return $role->children()->get();
    }

    /**
     * @inheritDoc
     */
    public function getParents(Role $role): Collection
    {
        return $role->parents()->get();
    }

    /**
     * @inheritDoc
     */
    public function addChild(Role $role, Role $childRole): void
    {
        $role->children()->attach($childRole);
    }
}