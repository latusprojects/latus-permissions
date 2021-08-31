<?php

namespace Latus\Permissions\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Latus\Permissions\Models\User;

class UserProvider implements \Illuminate\Contracts\Auth\UserProvider
{

    public function __construct(
        protected UserService $userService
    )
    {
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier): Authenticatable|null
    {
        /**
         * @var Authenticatable|null $user
         */
        $user = $this->userService->find($identifier);
        return $user;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|null
     */
    public function retrieveByToken($identifier, $token): Authenticatable|null
    {
        /**
         * @var Authenticatable|null $user
         */
        $user = $this->userService->find($identifier);

        return $user && $user->getRememberToken() && hash_equals($user->getRememberToken(), $token)
            ? $user : null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param Authenticatable $user
     * @param string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        /**
         * @var UserService $userService
         */
        $userService = app(UserService::class);

        /**
         * @var User $user
         */
        $userService->updateRememberTokenOfUser($user, $token);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials): Authenticatable|null
    {
        /**
         * @var Authenticatable|null $user
         */
        $user = $this->userService->findByCredentials($credentials);
        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return Hash::check(
            $credentials['password'], $user->getAuthPassword()
        );
    }
}