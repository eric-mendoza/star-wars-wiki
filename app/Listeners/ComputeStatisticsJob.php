<?php

namespace App\Listeners;

use App\Events\StatisticsUpdateRequested;
use App\Jobs\ComputeQueryStatistics;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ComputeStatisticsJob
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StatisticsUpdateRequested $event): void
    {
        Log::info('[Listener] StatisticsUpdateRequested fired.');
        ComputeQueryStatistics::dispatch();
    }
}
