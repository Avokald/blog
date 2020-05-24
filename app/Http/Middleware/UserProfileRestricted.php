<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class UserProfileRestricted
{
    /**
     * Handle requests for private user pages
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Stored user object from previous middlewares
        $userObserved = $request->attributes->get('userObserved');

        $currentUser = $request->user();

        if ($userObserved === null) {
            $sluggedId = $request->route('sluggedId');
            $sluggedIdExploded = explode('-', $sluggedId, 2);

            $userObserved = User::findOrFail($sluggedIdExploded[0]);

            $request->attributes->add(['userObserved' => $userObserved]);
        }

        // If not user's own profile then return 403
        if ($currentUser->id !== $userObserved->id) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
