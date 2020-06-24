<?php declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Comment;
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
     * @OA\Post(path="/api/v1/users",
     *   tags={"user"},
     *   summary="Create new user",
     *   description="",
     *   operationId="createNewUser",
     *
     *   @OA\Response(response=200, description="successful operation", @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(ref="#/components/schemas/User")
     *   )),
     * )
     *
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
     *  @OA\Get(path="/api/v1/users/{id}",
     *   tags={"user"},
     *   summary="Get user profile data by id",
     *   description="",
     *   operationId="getUserById",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The id of user that needs to be fetched",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(ref="#/components/schemas/User")
     *   )),
     *   @OA\Response(response=404, description="User not found")
     * )
     *
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

        return $userObserved;
    }

    // TODO
    const TOP_PATH_NAME = 'users.profile.top';
    public function top(string $profile, string $timeframe)
    {
        $profileExploded = explode('-', $profile, 2);

        $userObserved = User::findOrFail($profileExploded[0]);

        return  $userObserved;
    }

    const DRAFTS_PATH_NAME = 'users.profile.drafts';
    public function drafts(string $profile)
    {
        $profileExploded = explode('-', $profile, 2);
        $userObserved = User::withRelationOrderedBy('drafts', 'created_at', 'DESC')->findOrFail($profileExploded[0]);

        return $userObserved->drafts;
    }

    /**
     * @OA\Get(path="/api/v1/users/{id}/comments",
     *   tags={"user"},
     *   summary="Get user comments",
     *   description="",
     *   operationId="getUserComments",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The id of user",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/Comment")
     *         )),
     *   @OA\Response(response=404, description="User not found"),
     * )
     *
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    const COMMENTS_PATH_NAME = 'user.profile.comments';
    public function comments(string $profile)
    {
        $profileExploded = explode('-', $profile, 2);
//        $comments = DB::select("
//        SELECT comments.*, ':',
//        post.title as post_title, post.slug as post_slug,
//        user.id as author_id, user.name as author_name, user.slug as author_slug, user.image as author_image
//        FROM comments as comments
//        INNER JOIN posts as post
//        ON comments.post_id = post.id
//        INNER JOIN users as user
//        ON comments.user_id = user.id
//        WHERE comments.user_id = ?
//        ", [$profileExploded[0]]);

        $comments = Comment::with('post')
            ->where('user_id', $profileExploded[0])
            ->orderBy( 'created_at', 'DESC')
            ->get();

        return $comments;
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
     * @OA\Put(path="/api/v1/users/{id}",
     *   tags={"user"},
     *   summary="Update user profile data by id",
     *   description="",
     *   operationId="updateUserById",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The id of user that needs to be updated",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(ref="#/components/schemas/User")
     *   )),
     *   @OA\Response(response=404, description="User not found"),
     *
     *   @OA\RequestBody(
     *       required=true,
     *       description="Updated user object",
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/User")
     *       )
     *   ),
     * )
     *
     *
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
     * @OA\Delete(path="/api/v1/users/{id}",
     *   tags={"user"},
     *   summary="Delete user by id",
     *   description="",
     *   operationId="deleteUserById",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The id of user that needs to be deleted",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(ref="#/components/schemas/User")
     *   )),
     *   @OA\Response(response=404, description="User not found"),
     * )
     *
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
