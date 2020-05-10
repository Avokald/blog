<?php declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  string $profile
     * @return \Illuminate\Http\Response
     */
    const SHOW_PATH_NAME = 'users.profile';
    public function show(string $profile)
    {
        $profileExploded = explode('-', $profile, 2);
        $userObserved = User::findOrFail($profileExploded[0]);
        $currentUser = request()->user();

        // If profile is not public or not their own profile
        // then return 404
        if (!$userObserved->public && !($currentUser && ($currentUser->id === $userObserved->id))) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        // Redirect if slug is not provided or incorrect
        // Must be run later so the would be no redirect when profile is private
        if (!isset($profileExploded[1], $userObserved->slug) || ($profileExploded[1] !== $userObserved->slug)) {
            return redirect($userObserved->getPersonalPageLink());
        }

        return [
            'user' => $userObserved,
            'time' => microtime(true) - LARAVEL_START,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return;
    }
}
