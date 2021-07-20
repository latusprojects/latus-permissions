<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Repositories\Contracts\RoleRepository;

class RoleService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:3',
        'level' => 'required|integer|min:0|max:65556',
    ];

    public function __construct(
        protected RoleRepository $roleRepository
    )
    {
    }

    public function createRole(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->roleRepository->create($attributes);
    }

    public function find(int|string $id): Model|null
    {
        return $this->roleRepository->find($id);
    }

    public function findByName(string $name): Model|null
    {
        return $this->roleRepository->findByName($name);
    }

    public function deleteRole(Role $role)
    {
        return $this->roleRepository->delete($role);
    }

    public function addPermissionToRole(Role $role, Permission $permission)
    {
        $this->roleRepository->addPermission($role, $permission);
    }

    public function removePermissionFromRole(Role $role, Permission $permission): int
    {
        return $this->roleRepository->removePermission($role, $permission);
    }

    public function getPermissionsOfRole(Role $role): Collection
    {
        return $this->roleRepository->getPermissions($role);
    }

    public function getResolvedPermissionsOfRole(Role $role): Collection
    {
        return $this->roleRepository->getResolvedPermissions($role);
    }

    public function roleHasPermission(Role $role, Permission $permission): bool
    {
        return $this->roleRepository->hasPermission($role, $permission);
    }

    public function addUserToRole(Role $role, User $user)
    {
        $this->roleRepository->addUser($role, $user);
    }

    public function removeUserFromRole(Role $role, User $user): int
    {
        return $this->roleRepository->removeUser($role, $user);
    }

    public function getUsersOfRole(Role $role): Collection
    {
        return $this->roleRepository->getUsers($role);
    }

    public function roleHasUser(Role $role, User $user): bool
    {
        return $this->roleRepository->hasUser($role, $user);
    }


}