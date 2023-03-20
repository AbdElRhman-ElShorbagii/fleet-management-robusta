<?php

namespace App\Providers;

use App\Interfaces\ReservationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\ReservationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, ReservationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
