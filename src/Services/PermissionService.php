<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Repositories\Contracts\PermissionRepository;

class PermissionService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:3',
        'guard' => 'required|string|min:3',
    ];

    public function __construct(
        protected PermissionRepository $permissionRepository
    )
    {
    }

    public function createPermission(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->permissionRepository->create($attributes);
    }

    public function find(int|string $id): Model|null
    {
        return $this->permissionRepository->find($id);
    }

    public function findByName(string $name): Model|null
    {
        return $this->permissionRepository->findByName($name);
    }

    public function deletePermission(Permission $permission)
    {
        return $this->permissionRepository->delete($permission);
    }

    public function grantPermissionTo(Permission $permission, Permissible $permissible)
    {
        $this->permissionRepository->grantTo($permission, $permissible);
    }

    public function revokePermissionFrom(Permission $permission, Permissible $permissible): int
    {
        return $this->permissionRepository->revokeFrom($permission, $permissible);
    }

    public function isPermissionGrantedTo(Permission $permission, Permissible $permissible, bool $resolvePermissions = true): bool
    {
        return $this->permissionRepository->isGrantedTo($permission, $permissible, $resolvePermissions);
    }

    public function getRolesWithPermission(Permission $permission): Collection
    {
        return $this->permissionRepository->getRoles($permission);
    }

    public function getUsersWithPermission(Permission $permission): Collection
    {
        return $this->permissionRepository->getUsers($permission);
    }
}