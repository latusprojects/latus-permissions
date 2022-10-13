<?php


namespace Latus\Permissions\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Latus\Permissions\Helpers\Classes;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Repositories\Contracts\PermissionRepository as PermissionRepositoryContract;
use Latus\Repositories\EloquentRepository;

class PermissionRepository extends EloquentRepository implements PermissionRepositoryContract
{

    /**
     * @inheritDoc
     */
    public function delete(Permission $permission)
    {
        $permission->delete();
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $name): Permission|null
    {
        return $this->relatedModel()->where('name', $name)->first();
    }

    /**
     * @inheritDoc
     */
    public function relatedModel(): Model
    {
        return new (Classes::permission());
    }

    /**
     * @inheritDoc
     */
    public function grantTo(Permission $permission, Permissible $permissible)
    {
        $permissible->permissions()->attach($permission->id);
    }

    /**
     * @inheritDoc
     */
    public function revokeFrom(Permission $permission, Permissible $permissible): int
    {
        return $permissible->permissions()->detach($permission->id);
    }

    /**
     * @inheritDoc
     */
    public function isGrantedTo(Permission $permission, Permissible $permissible, bool $resolvePermissions = true): bool
    {
        if ($resolvePermissions) {
            return $permissible->resolvePermissions()->contains($permission);
        }
        return $permissible->permissions()->where('permission_id', $permission->id)->exists();
    }

    /**
     * @inheritDoc
     */
    public function getRoles(Permission $permission): Collection
    {
        return $permission->roles()->get();
    }

    /**
     * @inheritDoc
     */
    public function getUsers(Permission $permission): Collection
    {
        return $permission->users()->get();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->relatedModel()->all();
    }
}