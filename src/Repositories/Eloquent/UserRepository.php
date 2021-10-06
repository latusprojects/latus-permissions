<?php


namespace Latus\Permissions\Repositories\Eloquent;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Repositories\Contracts\UserRepository as UserRepositoryContract;
use Latus\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function relatedModel(): Model
    {
        return new User();
    }

    /**
     * @inheritDoc
     */
    public function delete(User $user)
    {
        $user->delete();
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $name): User|null
    {
        return $this->relatedModel()->where('name', $name)->first();
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): User|null
    {
        return $this->relatedModel()->where('email', $email)->first();
    }

    /**
     * @inheritDoc
     */
    public function findByCredentials(array $credentials): User|null
    {
        $query = $this->relatedModel();

        foreach ($credentials as $key => $value) {
            if (Str::contains($key, 'password')) {
                continue;
            }

            if (is_array($value) || $value instanceof Arrayable) {
                $query = $query->whereIn($key, $value);
            } else {
                $query = $query->where($key, $value);
            }
        }

        return $query->first();
    }

    /**
     * @inheritDoc
     */
    public function addRole(User $user, Role $role)
    {
        $user->roles()->attach($role->id);
    }

    /**
     * @inheritDoc
     */
    public function removeRole(User $user, Role $role): int
    {
        return $user->roles()->detach($role->id);
    }

    /**
     * @inheritDoc
     */
    public function getRoles(User $user): Collection
    {
        return $user->roles()->get();
    }

    /**
     * @inheritDoc
     */
    public function hasRole(User $user, Role $role): bool
    {
        return $user->roles()->where('role_id', $role->id)->exists();
    }

    /**
     * @inheritDoc
     */
    public function addPermission(User $user, Permission $permission)
    {
        $user->permissions()->attach($permission->id);
    }

    /**
     * @inheritDoc
     */
    public function removePermission(User $user, Permission $permission): int
    {
        return $user->permissions()->detach($permission->id);
    }

    /**
     * @inheritDoc
     */
    public function getPermissions(User $user): Collection
    {
        return $user->permissions()->get();
    }

    /**
     * @inheritDoc
     */
    public function getResolvedPermissions(User $user): Collection
    {
        return $user->resolvePermissions();
    }

    /**
     * @inheritDoc
     */
    public function hasPermission(User $user, Permission $permission): bool
    {
        return $user->resolvePermissions()->contains($permission);
    }

    /**
     * @inheritDoc
     */
    public function hasPermissionByString(User $user, string $permission): bool
    {
        return $user->hasPermission($permission);
    }

    /**
     * @inheritDoc
     */
    public function hasOnePermissionByStrings(User $user, array $permissions): bool
    {
        return $user->hasOnePermission($permissions);
    }

    /**
     * @inheritDoc
     */
    public function updateRememberToken(User $user, string $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }
}