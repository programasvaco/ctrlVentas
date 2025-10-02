<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CorteCajaService;
use Illuminate\Http\Request;

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
    }
}
