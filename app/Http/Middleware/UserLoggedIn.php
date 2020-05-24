<?php

namespace App\Http\Middleware;

use Closure;
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
        // If user not logged in then 403
        if ($request->user() === null) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
