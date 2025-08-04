<?php

namespace App\Providers;

use App\Events\StatisticsUpdateRequested;
use App\Listeners\ComputeStatisticsJob;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        StatisticsUpdateRequested::class => [
            ComputeStatisticsJob::class,
        ],
    ];
}
