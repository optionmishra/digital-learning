<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiRequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('POST')) {
            $logData = [
                'endpoint' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_id' => auth()->user()->id ?? 'unauthenticated',
                'request_time' => now()->format('Y-m-d H:i:s'),
                'input' => $request->all(),
                'headers' => $request->headers->all(),
            ];

            // Log the request data
            Log::channel('api-requests')->info('API Request', $logData);
        }

        return $next($request);
    }
}
