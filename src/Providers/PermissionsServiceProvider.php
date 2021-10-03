<?php

namespace Latus\Permissions\Providers;

use Illuminate\Support\ServiceProvider;
use Latus\Permissions\Repositories\Contracts\PermissionRepository as PermissionRepositoryContract;
use Latus\Permissions\Repositories\Eloquent\PermissionRepository;
use Latus\Permissions\Repositories\Contracts\RoleRepository as RoleRepositoryContract;
use Latus\Permissions\Repositories\Eloquent\RoleRepository;
use Latus\Permissions\Repositories\Contracts\UserRepository as UserRepositoryContract;
use Latus\Permissions\Repositories\Eloquent\UserRepository;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->app->bound(PermissionRepositoryContract::class)) {
            $this->app->bind(PermissionRepositoryContract::class, PermissionRepository::class);
        }

        if (!$this->app->bound(RoleRepositoryContract::class)) {
            $this->app->bind(RoleRepositoryContract::class, RoleRepository::class);
        }

        if (!$this->app->bound(UserRepositoryContract::class)) {
            $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
