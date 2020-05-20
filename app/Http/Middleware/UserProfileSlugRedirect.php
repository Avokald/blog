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
        $sluggedId = $request->route('sluggedId');
        $sluggedIdExploded = explode('-', $sluggedId, 2);


        if ($userObserved === null) {
            $userObserved = User::findOrFail($sluggedIdExploded[0]);

            $request->attributes->add(['userObserved' => $userObserved]);
        }

        if ($this->isUrlIncorrect($sluggedIdExploded, $userObserved)) {
            return redirect(route($routeName, $userObserved->slugged_id));
        }

        return $next($request);
    }

    /**
     * Checks if url has both slug and user has slug
     * if they are not equal returns true
     *
     * Can't use User model as sluggable package throws error in middleware test
     * Illuminate\Contracts\Container\BindingResolutionException:
     * Target [Illuminate\Contracts\Events\Dispatcher] is not instantiable while building
     * [Cviebrock\EloquentSluggable\SluggableObserver]
     *
     * @param array|null $sluggedIdExploded
     * @param $user
     * @return bool
     */
    public function isUrlIncorrect(?array $sluggedIdExploded, $user)
    {
        return (!isset($sluggedIdExploded[1], $user->slug) || ($sluggedIdExploded[1] !== $user->slug));
    }
}
