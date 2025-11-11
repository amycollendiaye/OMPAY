<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Compte;
use App\Policies\ComptePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Passport::tokensCan([
            'access' => 'Access API',
            'refresh' => 'Refresh Token',
        ]);
    }
}
