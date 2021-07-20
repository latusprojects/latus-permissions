<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Repositories\Contracts\Repository;

interface UserRepository extends Repository
{
    public function delete(User $user);

    public function findByName(string $name): User|null;

    public function addRole(User $user, Role $role);

    public function removeRole(User $user, Role $role): int;

    public function getRoles(User $user): Collection;

    public function hasRole(User $user, Role $role): bool;

    public function addPermission(User $user, Permission $permission);

    public function removePermission(User $user, Permission $permission): int;

    public function getPermissions(User $user): Collection;

    public function getResolvedPermissions(User $user): Collection;

    public function hasPermission(User $user, Permission $permission): bool;
}