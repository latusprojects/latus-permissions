<?php


namespace Latus\Permissions\Repositories\Eloquent;

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
}