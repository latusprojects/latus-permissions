<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Permission;
use Latus\Repositories\Contracts\Repository;

interface PermissionRepository extends Repository
{
    /**
     * Attempts to delete a permission model
     *
     * @param Permission $permission
     * @return mixed
     */
    public function delete(Permission $permission);

    /**
     * Attempts to find a permission model by name
     *
     * @param string $name
     * @return Permission|null
     */
    public function findByName(string $name): Permission|null;

    /**
     * Grants a permission to a specific user
     *
     * @param Permission $permission
     * @param Permissible $permissible
     * @return mixed
     */
    public function grantTo(Permission $permission, Permissible $permissible);

    /**
     * Revokes a permission from a specific user
     *
     * @param Permission $permission
     * @param Permissible $permissible
     * @return int
     */
    public function revokeFrom(Permission $permission, Permissible $permissible): int;

    /**
     * Checks if a permission is granted to a specific user
     *
     * @param Permission $permission
     * @param Permissible $permissible
     * @param bool $resolvePermissions
     * @return bool
     */
    public function isGrantedTo(Permission $permission, Permissible $permissible, bool $resolvePermissions = true): bool;

    /**
     * Get roles that were granted this specific permission
     *
     * @param Permission $permission
     * @return Collection
     */
    public function getRoles(Permission $permission): Collection;

    /**
     * Get users that were granted this specific permission
     *
     * @param Permission $permission
     * @return Collection
     */
    public function getUsers(Permission $permission): Collection;
}