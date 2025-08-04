<?php

namespace App\Providers;

use App\Events\StatisticsUpdateRequested;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            event(new StatisticsUpdateRequested());
        }
    }
}
