<?php


namespace Latus\Permissions\Repositories\Contracts;


use Illuminate\Support\Collection;
use Latus\Permissions\Models\User;
use Latus\Repositories\Contracts\Repository;

interface UserRepository extends Repository
{
    public function delete(User $user);

    public function findByName(string $name): User|null;

    public function resolvePermissions(User $user): Collection;
}