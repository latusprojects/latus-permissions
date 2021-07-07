<?php


namespace Latus\Permissions\Repositories\Eloquent;


use Latus\Permissions\Models\Permission;
use Latus\Repositories\EloquentRepository;
use Latus\Permissions\Repositories\Contracts\PermissionRepository as PermissionRepositoryContract;

class PermissionRepository extends EloquentRepository implements PermissionRepositoryContract
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
    }
}