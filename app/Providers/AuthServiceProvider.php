<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define a gate for admin panel access
        Gate::define('access-admin', function (User $user) {
            return in_array($user->role, ['admin', 'superadmin']);
        });
    }
}