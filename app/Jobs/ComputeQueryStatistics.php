<?php

namespace App\Jobs;

use App\Models\QueryLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class ComputeQueryStatistics implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $since = now()->subDays(7);
        $logs = QueryLog::where('created_at', '>=', $since)->get();

        $total = $logs->count();
        $avgDuration = round($logs->avg('duration'), 3);
        $popularHour = $logs->groupBy(fn($log) => $log->created_at->format('H'))->map->count()->sortDesc()->keys()->first();
        $topLocations = $logs->groupBy('location')->map->count()->sortDesc()->take(5);
        $topBrowsers = $logs->groupBy('browser')->map->count()->sortDesc()->take(5);

        $stats = [
            'avg_duration' => $avgDuration,
            'popular_hour' => $popularHour,
            'top_locations' => $topLocations,
            'top_browsers' => $topBrowsers,
        ];

        Cache::put('query_statistics', $stats, now()->addMinutes(10));
    }
}
