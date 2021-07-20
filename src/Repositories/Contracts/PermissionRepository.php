<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Permission;
use Latus\Repositories\Contracts\Repository;

interface PermissionRepository extends Repository
{
    public function delete(Permission $permission);

    public function findByName(string $name): Permission|null;

    public function grantTo(Permission $permission, Permissible $permissible);

    public function revokeFrom(Permission $permission, Permissible $permissible): int;

    public function isGrantedTo(Permission $permission, Permissible $permissible, bool $resolvePermissions = true): bool;

    public function getRoles(Permission $permission): Collection;

    public function getUsers(Permission $permission): Collection;
}