<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\Role;
use Latus\Repositories\Contracts\Repository;

interface RoleRepository extends Repository
{
    public function delete(Role $role);

    public function findByName(string $name): Role|null;

    public function resolvePermissions(Role $role): Collection;
}