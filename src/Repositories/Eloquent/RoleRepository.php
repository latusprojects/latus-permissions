<?php


namespace Latus\Permissions\Repositories\Eloquent;


use Latus\Permissions\Models\Role;
use Latus\Repositories\EloquentRepository;
use Latus\Permissions\Repositories\Contracts\RoleRepository as RoleRepositoryContract;

class RoleRepository extends EloquentRepository implements RoleRepositoryContract
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function delete(Role $role)
    {
        $role->delete();
    }

    public function findByName(string $name): Role|null
    {
        return $this->model->where('name', $name)->first();
    }
}