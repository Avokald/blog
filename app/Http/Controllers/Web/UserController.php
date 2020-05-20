<?php declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


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
        $userObserved = User::withRelationOrderedBy('posts', 'created_at', 'DESC')
            ->with('pinned_post')
            ->findOrFail($profileExploded[0]);

        return [
            'user' => $userObserved,
            'time' => microtime(true) - LARAVEL_START,
        ];
    }

    const DRAFTS_PATH_NAME = 'users.profile.drafts';
    public function drafts(string $profile)
    {
        $profileExploded = explode('-', $profile, 2);
        $userObserved = User::withRelationOrderedBy('drafts', 'created_at', 'DESC')->findOrFail($profileExploded[0]);

        return [
            'drafts' => $userObserved->drafts,
            'time' => microtime(true) - LARAVEL_START,
        ];
    }

    const COMMENTS_PATH_NAME = 'user.profile.comments';
    public function comments(string $profile)
    {
        $profileExploded = explode('-', $profile, 2);
        $userObserved = User::withRelationOrderedBy('comments', 'created_at', 'DESC')->findOrFail($profileExploded[0]);

        return [
            'comments' => $userObserved->comments,
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
