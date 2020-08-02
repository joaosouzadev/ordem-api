<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    DesignInterface,
    UserInterface,
    ClienteInterface,
    OrdemInterface,
};
use App\Repositories\Eloquent\{
    DesignRepository,
    UserRepository,
    ClienteRepository,
    OrdemRepository,
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(DesignInterface::class, DesignRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);
        $this->app->bind(OrdemInterface::class, OrdemRepository::class);
    }
}
