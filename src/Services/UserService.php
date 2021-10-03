<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Repositories\Contracts\UserRepository;
use Latus\Repositories\Contracts\Repository;

class UserService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email',
        'password' => 'required|string|min:10|max:255',
    ];

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    /**
     * Attempts to create new user
     *
     * @param array $attributes
     * @return Model
     * @see Repository::create()
     */
    public function createUser(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        $attributes['password'] = Hash::make($attributes['password']);

        return $this->userRepository->create($attributes);
    }

    /**
     * Attempts to find a user by id
     *
     * @param int|string $id
     * @return Model|null
     * @see Repository::find()
     */
    public function find(int|string $id): Model|null
    {
        return $this->userRepository->find($id);
    }

    /**
     * Attempts to find a user by name
     *
     * @param string $name
     * @return Model|null
     * @see UserRepository::findByName()
     */
    public function findByName(string $name): Model|null
    {
        return $this->userRepository->findByName($name);
    }

    /**
     * Attempts to find a user by email
     *
     * @param string $email
     * @return Model|null
     * @see UserRepository::findByEmail()
     */
    public function findByEmail(string $email): Model|null
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Attempts to find a user by specific credentials
     *
     * @param array $credentials
     * @return User|null
     * @see UserRepository::findByCredentials()
     */
    public function findByCredentials(array $credentials): User|null
    {
        return $this->userRepository->findByCredentials($credentials);
    }

    /**
     * Attempts to delete a user model
     *
     * @param User $user
     * @return mixed
     * @see UserRepository::delete()
     */
    public function deleteUser(User $user): mixed
    {
        return $this->userRepository->delete($user);
    }

    /**
     * Adds a specific role to a user
     *
     * @param User $user
     * @param Role $role
     * @see UserRepository::addRole()
     */
    public function addRoleToUser(User $user, Role $role)
    {
        $this->userRepository->addRole($user, $role);
    }

    /**
     * Attempts to remove a specific role from a user
     *
     * @param User $user
     * @param Role $role
     * @return int
     * @see UserRepository::removeRole()
     */
    public function removeRoleFromUser(User $user, Role $role): int
    {
        return $this->userRepository->removeRole($user, $role);
    }

    /**
     * Gets all roles of a user
     *
     * @param User $user
     * @return Collection
     * @see UserRepository::getRoles()
     */
    public function getRolesOfUser(User $user): Collection
    {
        return $this->userRepository->getRoles($user);
    }

    /**
     * Checks if a user has a specific role
     *
     * @param User $user
     * @param Role $role
     * @return bool
     * @see UserRepository::hasRole()
     */
    public function userHasRole(User $user, Role $role): bool
    {
        return $this->userRepository->hasRole($user, $role);
    }

    /**
     * Adds a specific permission to a user
     *
     * @param User $user
     * @param Permission $permission
     * @see UserRepository::addPermission()
     */
    public function addPermissionToUser(User $user, Permission $permission)
    {
        $this->userRepository->addPermission($user, $permission);
    }

    /**
     * Removes a specific permission from a user
     *
     * @param User $user
     * @param Permission $permission
     * @return int
     * @see UserRepository::removePermission()
     */
    public function removePermissionFromUser(User $user, Permission $permission): int
    {
        return $this->userRepository->removePermission($user, $permission);
    }

    /**
     * Gets permissions of a user, excluding those of parent and child models
     *
     * @param User $user
     * @return Collection
     * @see UserRepository::getPermissions()
     */
    public function getPermissionsOfUser(User $user): Collection
    {
        return $this->userRepository->getPermissions($user);
    }

    /**
     * Gets all permissions of a user, including those of parent and child models
     *
     * @param User $user
     * @return Collection
     * @see UserRepository::getResolvedPermissions()
     */
    public function getResolvedPermissionsOfUser(User $user): Collection
    {
        return $this->userRepository->getResolvedPermissions($user);
    }

    /**
     * Checks if a user has a specific permission by model
     *
     * @param User $user
     * @param Permission $permission
     * @return bool
     * @see UserRepository::hasPermission()
     */
    public function userHasPermission(User $user, Permission $permission): bool
    {
        return $this->userRepository->hasPermission($user, $permission);
    }

    /**
     * Checks if a user has a specific permission by string
     *
     * @param User $user
     * @param string $permission
     * @return bool
     * @see UserRepository::hasPermissionByString()
     */
    public function userHasPermissionByString(User $user, string $permission): bool
    {
        return $this->userRepository->hasPermissionByString($user, $permission);
    }

    /**
     * Checks if a user has at least one of the specified permissions
     *
     * @param User $user
     * @param array $permissions
     * @return bool
     * @see UserRepository::hasOnePermissionByStrings()
     */
    public function userHasOnePermissionByStrings(User $user, array $permissions): bool
    {
        return $this->userRepository->hasOnePermissionByStrings($user, $permissions);
    }

    /**
     * Updates the remember-token field
     *
     * @param User $user
     * @param string $token
     * @see UserRepository::updateRememberToken()
     */
    public function updateRememberTokenOfUser(User $user, string $token)
    {
        $this->userRepository->updateRememberToken($user, $token);
    }

}