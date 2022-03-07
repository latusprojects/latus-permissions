<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Repositories\Contracts\PermissionRepository;
use Latus\Repositories\Contracts\Repository;

class PermissionService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:3',
        'guard' => 'required|string|min:3',
    ];

    /**
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        protected PermissionRepository $permissionRepository
    )
    {
    }

    /**
     * Validates attributes, then attempts to create a permission on success
     * or throw an exception on failure
     *
     * @param array $attributes
     * @return Model
     * @see Repository::create()
     */
    public function createPermission(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->permissionRepository->create($attributes);
    }

    /**
     * Attempts to find a permission by id
     *
     * @param int|string $id
     * @return Model|null
     * @see Repository::find()
     */
    public function find(int|string $id): Model|null
    {
        return $this->permissionRepository->find($id);
    }

    /**
     * Attempts to find a permission by name
     *
     * @param string $name
     * @return Model|null
     * @see PermissionRepository::findByName()
     */
    public function findByName(string $name): Model|null
    {
        return $this->permissionRepository->findByName($name);
    }

    /**
     * Attempts to delete a permission
     *
     * @param Permission $permission
     * @return mixed
     * @see PermissionRepository::delete()
     */
    public function deletePermission(Permission $permission)
    {
        return $this->permissionRepository->delete($permission);
    }

    /**
     * Grants a permission to a specific permissible model
     *
     * @param Permission $permission
     * @param Permissible $permissible
     * @see PermissionRepository::grantTo()
     */
    public function grantPermissionTo(Permission $permission, Permissible $permissible)
    {
        $this->permissionRepository->grantTo($permission, $permissible);
    }

    /**
     * Revokes a permission from a specific permissible model
     *
     * @param Permission $permission
     * @param Permissible $permissible
     * @return int
     * @see PermissionRepository::revokeFrom()
     */
    public function revokePermissionFrom(Permission $permission, Permissible $permissible): int
    {
        return $this->permissionRepository->revokeFrom($permission, $permissible);
    }

    /**
     * Checks if a permission is granted to a specific permissible model
     *
     * @param Permission $permission
     * @param Permissible $permissible
     * @param bool $resolvePermissions
     * @return bool
     * @see PermissionRepository::isGrantedTo()
     */
    public function isPermissionGrantedTo(Permission $permission, Permissible $permissible, bool $resolvePermissions = true): bool
    {
        return $this->permissionRepository->isGrantedTo($permission, $permissible, $resolvePermissions);
    }

    /**
     * Get roles that were granted this specific permission
     *
     * @param Permission $permission
     * @return Collection
     * @see PermissionRepository::getRoles()
     */
    public function getRolesWithPermission(Permission $permission): Collection
    {
        return $this->permissionRepository->getRoles($permission);
    }

    /**
     * Get users that were granted this specific permission
     *
     * @param Permission $permission
     * @return Collection
     * @see PermissionRepository::getUsers()
     */
    public function getUsersWithPermission(Permission $permission): Collection
    {
        return $this->permissionRepository->getUsers($permission);
    }

    /**
     * Retrieves all permissions
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->permissionRepository->all();
    }
}