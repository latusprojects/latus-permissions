<?php

namespace Latus\Permissions\Providers;

use Illuminate\Support\Facades\Auth;
use Latus\Permissions\Services\UserProvider;

class AuthServiceProvider extends \Illuminate\Foundation\Support\Providers\AuthServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('service', function ($app, array $config) {
            return $app->make(UserProvider::class);
        });
    }
}