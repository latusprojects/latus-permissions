<?php


namespace Latus\Permissions\Repositories\Contracts;


use Latus\Permissions\Models\User;
use Latus\Repositories\Contracts\Repository;

interface UserRepository extends Repository
{
    public function delete(User $user);
}