<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class UserProfileSlugRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getAction('as');
        $userObserved = $request->attributes->get('userObserved');
        $profile = $request->route('profile');
        $profileExploded = explode('-', $profile, 2);


        if ($userObserved === null) {
            $userObserved = User::findOrFail($profileExploded[0]);

            $request->attributes->add(['userObserved' => $userObserved]);
        }

        // Redirect if slug is not provided or incorrect
        if (!isset($profileExploded[1], $userObserved->slug) || ($profileExploded[1] !== $userObserved->slug)) {
            return redirect(route($routeName, $userObserved->slugged_id));
        }

        return $next($request);
    }
}
