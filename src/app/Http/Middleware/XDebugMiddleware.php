<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XDebugMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!extension_loaded('xdebug')) {
            return $next($request);
        }

        $response = $next($request);

        $executionTime = round(xdebug_time_index() * 1000, 2);
        $memoryUsage = round(xdebug_peak_memory_usage() / 1024, 2);


        $response->headers->set('X-Debug-Time', "{$executionTime} ms");
        $response->headers->set('X-Debug-Memory', "{$memoryUsage} KB");

        return $response;
    }
}
