<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Repositories\Contracts\RoleRepository;
use Latus\Repositories\Contracts\Repository;

class RoleService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:3',
        'level' => 'required|integer|min:0|max:65556',
    ];

    public static array $update_validation_rules = [
        'name' => 'required|string|min:3',
        'level' => 'required|integer|min:0|max:65556',
    ];


    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        protected RoleRepository $roleRepository
    )
    {
    }

    /**
     * Validates attributes, then attempts to create a role on success
     * or throw an exception on failure
     *
     * @param array $attributes
     * @return Model
     * @see Repository::create()
     */
    public function createRole(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->roleRepository->create($attributes);
    }

    /**
     * Validates attributes, then attempts to update a role on success
     * or throw an exception on failure
     *
     * @param Role $role
     * @param array $attributes
     * @return Model
     * @see Repository::update()
     */
    public function updateRole(Role $role, array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$update_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->roleRepository->update($role, $attributes);
    }

    /**
     * Attempts to find a role by id
     *
     * @param int|string $id
     * @return Model|null
     * @see Repository::find()
     */
    public function find(int|string $id): Model|null
    {
        return $this->roleRepository->find($id);
    }

    /**
     * Attempts to find a role by name
     *
     * @param string $name
     * @return Model|null
     * @see RoleRepository::findByName()
     */
    public function findByName(string $name): Model|null
    {
        return $this->roleRepository->findByName($name);
    }

    /**
     * Attempts to delete a role model
     *
     * @param Role $role
     * @return mixed
     * @see RoleRepository::delete()
     */
    public function deleteRole(Role $role)
    {
        return $this->roleRepository->delete($role);
    }

    /**
     * Adds a specific permission to a role
     *
     * @param Role $role
     * @param Permission $permission
     * @see RoleRepository::addPermission()
     */
    public function addPermissionToRole(Role $role, Permission $permission)
    {
        $this->roleRepository->addPermission($role, $permission);
    }

    /**
     * Removes a specific permission from a role
     *
     * @param Role $role
     * @param Permission $permission
     * @return int
     * @see RoleRepository::removePermission()
     */
    public function removePermissionFromRole(Role $role, Permission $permission): int
    {
        return $this->roleRepository->removePermission($role, $permission);
    }

    /**
     * Gets permissions of a role, excluding those of parent and child models
     *
     * @param Role $role
     * @return Collection
     * @see RoleRepository::getPermissions()
     */
    public function getPermissionsOfRole(Role $role): Collection
    {
        return $this->roleRepository->getPermissions($role);
    }

    /**
     * Gets all permissions of a role, including those of parent and child models
     *
     * @param Role $role
     * @return Collection
     * @see RoleRepository::getResolvedPermissions()
     */
    public function getResolvedPermissionsOfRole(Role $role): Collection
    {
        return $this->roleRepository->getResolvedPermissions($role);
    }

    /**
     * Checks if a role has a specific permission
     *
     * @param Role $role
     * @param Permission $permission
     * @return bool
     * @see RoleRepository::hasPermission()
     */
    public function roleHasPermission(Role $role, Permission $permission): bool
    {
        return $this->roleRepository->hasPermission($role, $permission);
    }

    /**
     * Adds a specific user to a role
     *
     * @param Role $role
     * @param User $user
     * @see RoleRepository::addUser()
     */
    public function addUserToRole(Role $role, User $user)
    {
        $this->roleRepository->addUser($role, $user);
    }

    /**
     * Attempts to remove a specific user from a role
     *
     * @param Role $role
     * @param User $user
     * @return int
     * @see RoleRepository::removeUser()
     */
    public function removeUserFromRole(Role $role, User $user): int
    {
        return $this->roleRepository->removeUser($role, $user);
    }

    /**
     * Gets all users with this role
     *
     * @param Role $role
     * @return Collection
     * @see RoleRepository::getUsers()
     */
    public function getUsersOfRole(Role $role): Collection
    {
        return $this->roleRepository->getUsers($role);
    }

    /**
     * Checks if a specific user has a role
     *
     * @param Role $role
     * @param User $user
     * @return bool
     * @see RoleRepository::hasUser()
     */
    public function roleHasUser(Role $role, User $user): bool
    {
        return $this->roleRepository->hasUser($role, $user);
    }

    /**
     * Gets all child-roles of a role
     *
     * @param Role $role
     * @return Collection
     * @see RoleRepository::getChildren()
     */
    public function getChildren(Role $role): Collection
    {
        return $this->roleRepository->getChildren($role);
    }

    /**
     * Gets all parent-roles of a role
     *
     * @param Role $role
     * @return Collection
     */
    public function getParents(Role $role): Collection
    {
        return $this->roleRepository->getParents($role);
    }

    /**
     * Add a child-role to a role
     *
     * @param Role $role
     * @param Role $childRole
     * @return mixed
     */
    public function addChild(Role $role, Role $childRole): void
    {
        $this->roleRepository->addChild($role, $childRole);
    }

    /**
     * Retrieves all roles
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->roleRepository->all();
    }

}