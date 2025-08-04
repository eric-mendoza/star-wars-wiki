<?php

use App\Events\StatisticsUpdateRequested;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\LogQueryMetadata;
use App\Providers\EventServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('web', HandleInertiaRequests::class);
        $middleware->appendToGroup('api', LogQueryMetadata::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            event(new StatisticsUpdateRequested());
        })->everyMinute(); // TODO: Change to 5 minutes
    })
    ->withProviders([
        EventServiceProvider::class,
    ])
    ->create();
