<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Distributeur;
use App\Models\Transaction;
use App\Observers\ClientObserver;
use App\Observers\CompteObserver;
use App\Observers\DistributeurObserver;
use App\Observers\TransactionObserver;
use App\Repositories\ClientRepository;
use App\Repositories\CompteRepository;
use App\Repositories\IRepositoryClient;
use App\Repositories\IRepositoryCompte;
use App\Services\DestinataireCompte;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IRepositoryClient::class, ClientRepository::class);
        $this->app->bind(IRepositoryCompte::class, CompteRepository::class);
            $this->app->singleton(DestinataireCompte::class);IRepositoryCompte:

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Client::observe(ClientObserver::class);
        Compte::observe(CompteObserver::class);
        Transaction::observe(TransactionObserver::class);
        Distributeur::observe(DistributeurObserver::class);
    }
}
