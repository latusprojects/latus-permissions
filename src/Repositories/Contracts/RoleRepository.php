<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Repositories\Contracts\Repository;

interface RoleRepository extends Repository
{
    public function delete(Role $role);

    public function findByName(string $name): Role|null;

    public function addPermission(Role $role, Permission $permission);

    public function removePermission(Role $role, Permission $permission): int;

    public function getPermissions(Role $role): Collection;

    public function getResolvedPermissions(Role $role): Collection;

    public function hasPermission(Role $role, Permission $permission): bool;

    public function addUser(Role $role, User $user);

    public function removeUser(Role $role, User $user): int;

    public function getUsers(Role $role): Collection;

    public function hasUser(Role $role, User $user): bool;
}