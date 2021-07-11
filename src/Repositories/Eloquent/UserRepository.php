<?php


namespace Latus\Permissions\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Latus\Permissions\Models\User;
use Latus\Permissions\Repositories\Contracts\UserRepository as UserRepositoryContract;
use Latus\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryContract
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function findByName(string $name): User|null
    {
        return $this->model->where('name', $name)->first();
    }

    public function resolvePermissions(User $user): Collection
    {
        return $user->resolvePermissions();
    }
}