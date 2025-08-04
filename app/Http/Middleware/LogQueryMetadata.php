<?php

namespace App\Http\Middleware;

use App\Models\QueryLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogQueryMetadata
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $start;

        $ip = $request->header('X-Forwarded-For') ?? $request->ip();
        $browser = $request->header('User-Agent');
        $location = null;

        $endpoint = $request->route()?->getName() ?? $request->path();

        QueryLog::create([
            'duration' => $duration,
            'ip' => $ip,
            'location' => '', // TODO: IP providers are paid, so I removed it
            'browser' => $browser,
            'endpoint' => $endpoint,
            'created_at' => now(),
        ]);

        return $response;    }
}
