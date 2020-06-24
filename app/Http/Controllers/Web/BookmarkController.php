<?php declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;


class BookmarkController extends Controller
{
    /**
     *
     *
     * @OA\Get(path="/api/v1/users/{id}/bookmarks",
     *   tags={"user"},
     *   summary="Get user bookmarked posts",
     *   description="",
     *   operationId="getUserBookmarks",
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
     *            @OA\Items(ref="#/components/schemas/Bookmark")
     *         )),
     *   @OA\Response(response=404, description="User not found"),
     * )
     *
     *
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const INDEX_PATH_NAME = 'bookmarks.index';
    public function index(string $profile)
    {
        $profileExploded = explode('-', $profile, 2);
        $userObserved = User::withRelationOrderedBy('bookmarks', 'created_at', 'DESC')->findOrFail($profileExploded[0]);
        $currentUser = request()->user();

        // If profile is not public or not their own profile
        // then return 404
        if (!($currentUser && ($currentUser->id === $userObserved->id))) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        return $userObserved->bookmarks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    const STORE_PATH_NAME = 'bookmarks.store';
    public function store()
    {
        $user = request()->user();
        $postId = request()->post_id;

        if (is_null($user)) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $bookmark = $user->bookmarks()->where('post_id', $postId)->first();

        if (is_null($bookmark)) {
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $postId,
            ]);
        }

        return $user->getBookmarkedPostsId();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    const DESTROY_PATH_NAME = 'bookmarks.destroy';
    public function destroy()
    {
        $user = request()->user();
        $postId = request()->post_id;

        if (is_null($user)) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $bookmark = $user->bookmarks()->where('post_id', $postId)->first();

        if (!is_null($bookmark)) {
            $bookmark->delete();
        }


        return $user->getBookmarkedPostsId();
    }
}
