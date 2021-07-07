<?php


namespace Latus\Permissions\Repositories\Contracts;


use Latus\Permissions\Models\Role;
use Latus\Repositories\Contracts\Repository;

interface RoleRepository extends Repository
{
    public function delete(Role $role);
}