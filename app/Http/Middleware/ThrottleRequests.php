<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests as ThrottleRequestsBase;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests extends ThrottleRequestsBase
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = ''): Response
    {
        if (config('app.api_secret') !== null && $request->headers->get('Secret') === config('app.api_secret')) {
            return $next($request);
        }

        if (is_string($maxAttempts)
            && func_num_args() === 3
            && !is_null($limiter = $this->limiter->limiter($maxAttempts))) {
            return $this->handleRequestUsingNamedLimiter($request, $next, $maxAttempts, $limiter);
        }

        return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }
}
