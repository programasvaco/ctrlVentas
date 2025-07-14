<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CorteCajaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CorteCajaService::class, function ($app) {
            return new CorteCajaService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
