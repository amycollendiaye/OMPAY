<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Repositories\IRepositoryClient::class, \App\Repositories\ClientRepository::class);
        $this->app->bind(\App\Repositories\IRepositoryCompte::class, \App\Repositories\CompteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Client::observe(\App\Observers\ClientObserver::class);
        \App\Models\Compte::observe(\App\Observers\CompteObserver::class);
    }
}

