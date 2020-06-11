<?php

namespace App\Http\Middleware;

use Closure;
use Prometheus\Exception\MetricsRegistrationException;
use Symfony\Component\HttpFoundation\Response;

class UserLoggedIn
{
    /**
     * Handle requests for pages that require user to be logged in
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         try {
            $adapter = new \Prometheus\Storage\Redis([
                'host' => 'redis1',
                'port' => 6379,
                'password' => null,
                'timeout' => 0.1, // in seconds
                'read_timeout' => '10', // in seconds
                'persistent_connections' => false
            ]);

            $registry = new \Prometheus\CollectorRegistry($adapter);
            $counter = $registry->getOrRegisterCounter('test', 'user_logged_in', 'Number of times users logged in');
            $counter->inc();
        } catch (MetricsRegistrationException $e) {
            dd('heere');
        }
        // If user not logged in then 403
        if ($request->user() === null) {
            return abort(Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
