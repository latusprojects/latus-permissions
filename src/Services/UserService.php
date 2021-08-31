<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Models\Permission;
use Latus\Permissions\Models\Role;
use Latus\Permissions\Models\User;
use Latus\Permissions\Repositories\Contracts\UserRepository;

class UserService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email',
        'password' => 'required|string|min:10|max:255',
    ];

    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    public function createUser(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->userRepository->create($attributes);
    }

    public function find(int|string $id): Model|null
    {
        return $this->userRepository->find($id);
    }

    public function findByName(string $name): Model|null
    {
        return $this->userRepository->findByName($name);
    }

    public function findByEmail(string $email): Model|null
    {
        return $this->userRepository->findByEmail($email);
    }

    public function findByCredentials(array $credentials): User|null
    {
        return $this->userRepository->findByCredentials($credentials);
    }

    public function deleteUser(User $user)
    {
        return $this->userRepository->delete($user);
    }

    public function addRoleToUser(User $user, Role $role)
    {
        $this->userRepository->addRole($user, $role);
    }

    public function removeRoleFromUser(User $user, Role $role): int
    {
        return $this->userRepository->removeRole($user, $role);
    }

    public function getRolesOfUser(User $user): Collection
    {
        return $this->userRepository->getRoles($user);
    }

    public function userHasRole(User $user, Role $role): bool
    {
        return $this->userRepository->hasRole($user, $role);
    }

    public function addPermissionToUser(User $user, Permission $permission)
    {
        $this->userRepository->addPermission($user, $permission);
    }

    public function removePermissionFromUser(User $user, Permission $permission): int
    {
        return $this->userRepository->removePermission($user, $permission);
    }

    public function getPermissionsOfUser(User $user): Collection
    {
        return $this->userRepository->getPermissions($user);
    }

    public function getResolvedPermissionsOfUser(User $user): Collection
    {
        return $this->userRepository->getResolvedPermissions($user);
    }

    public function userHasPermission(User $user, Permission $permission): bool
    {
        return $this->userRepository->hasPermission($user, $permission);
    }

    public function updateRememberTokenOfUser(User $user, string $token)
    {
        $this->userRepository->updateRememberToken($user, $token);
    }

}