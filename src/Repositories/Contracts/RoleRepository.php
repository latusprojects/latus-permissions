<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Repositories\Contracts\Repository;

interface RoleRepository extends Repository
{
    /**
     * Attempts to delete a role model
     *
     * @param Role $role
     * @return mixed
     */
    public function delete(Role $role);

    /**
     * Attempts to find a role model by name
     *
     * @param string $name
     * @return Role|null
     */
    public function findByName(string $name): Role|null;

    /**
     * Adds a specific permission to a role
     *
     * @param Role $role
     * @param Permission $permission
     * @return mixed
     */
    public function addPermission(Role $role, Permission $permission);

    /**
     * Removes a specific permission from a role
     *
     * @param Role $role
     * @param Permission $permission
     * @return int
     */
    public function removePermission(Role $role, Permission $permission): int;

    /**
     * Gets permissions of a role, excluding those of parent and child models
     *
     * @param Role $role
     * @return Collection
     */
    public function getPermissions(Role $role): Collection;

    /**
     * Gets all permissions of a role, including those of parent and child models
     *
     * @param Role $role
     * @return Collection
     */
    public function getResolvedPermissions(Role $role): Collection;

    /**
     * Checks if a role has a specific permission
     *
     * @param Role $role
     * @param Permission $permission
     * @return bool
     */
    public function hasPermission(Role $role, Permission $permission): bool;

    /**
     * Adds a specific user to a role
     *
     * @param Role $role
     * @param User $user
     * @return mixed
     */
    public function addUser(Role $role, User $user);

    /**
     * Attempts to remove a specific user from a role
     *
     * @param Role $role
     * @param User $user
     * @return int
     */
    public function removeUser(Role $role, User $user): int;

    /**
     * Gets all users with this role
     *
     * @param Role $role
     * @return Collection
     */
    public function getUsers(Role $role): Collection;

    /**
     * Checks if a specific user has a role
     *
     * @param Role $role
     * @param User $user
     * @return bool
     */
    public function hasUser(Role $role, User $user): bool;

    /**
     * Gets all child-roles
     *
     * @param Role $role
     * @return Collection
     */
    public function getChildren(Role $role): Collection;

    /**
     * Gets all parent-roles
     *
     * @param Role $role
     * @return Collection
     */
    public function getParents(Role $role): Collection;

    /**
     * Add a child-role to a role
     *
     * @param Role $role
     * @param Role $childRole
     * @return mixed
     */
    public function addChild(Role $role, Role $childRole): void;
}