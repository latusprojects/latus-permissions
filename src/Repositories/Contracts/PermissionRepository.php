<?php


namespace Latus\Permissions\Repositories\Contracts;


use Latus\Permissions\Models\Permission;
use Latus\Repositories\Contracts\Repository;

interface PermissionRepository extends Repository
{
    public function delete(Permission $permission);
}