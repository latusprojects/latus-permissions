<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Repositories\Contracts\Repository;

interface UserRepository extends Repository
{
    /**
     * Attempts to delete a user model
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user);

    /**
     * Attempts to find a user by name
     *
     * @param string $name
     * @return User|null
     */
    public function findByName(string $name): User|null;

    /**
     * Attempts to find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): User|null;

    /**
     * Attempts to find a user by specific credentials
     *
     * @param array $credentials
     * @return User|null
     */
    public function findByCredentials(array $credentials): User|null;

    /**
     * Adds a specific role to a user
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function addRole(User $user, Role $role);

    /**
     * Attempts to remove a specific role from a user
     *
     * @param User $user
     * @param Role $role
     * @return int
     */
    public function removeRole(User $user, Role $role): int;

    /**
     * Gets all roles of a user
     *
     * @param User $user
     * @return Collection
     */
    public function getRoles(User $user): Collection;

    /**
     * Checks if a user has a specific role
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function hasRole(User $user, Role $role): bool;

    /**
     * Adds a specific permission to a user
     *
     * @param User $user
     * @param Permission $permission
     * @return mixed
     */
    public function addPermission(User $user, Permission $permission);

    /**
     * Removes a specific permission from a user
     *
     * @param User $user
     * @param Permission $permission
     * @return int
     */
    public function removePermission(User $user, Permission $permission): int;

    /**
     * Gets permissions of a user, excluding those of parent and child models
     *
     * @param User $user
     * @return Collection
     */
    public function getPermissions(User $user): Collection;

    /**
     * Gets all permissions of a user, including those of parent and child models
     *
     * @param User $user
     * @return Collection
     */
    public function getResolvedPermissions(User $user): Collection;

    /**
     * Checks if a user has a specific permission by model
     *
     * @param User $user
     * @param Permission $permission
     * @return bool
     */
    public function hasPermission(User $user, Permission $permission): bool;

    /**
     * Checks if a user has a specific permission by string
     *
     * @param User $user
     * @param string $permission
     * @return bool
     */
    public function hasPermissionByString(User $user, string $permission): bool;

    /**
     * Checks if a user has at least one of the specified permissions
     *
     * @param User $user
     * @param array $permissions
     * @return bool
     */
    public function hasOnePermissionByStrings(User $user, array $permissions): bool;

    /**
     * Updates the remember-token field
     *
     * @param User $user
     * @param string $token
     * @return mixed
     */
    public function updateRememberToken(User $user, string $token);

    /**
     * Get all users
     *
     * @return Collection
     */
    public function all(): Collection;
}