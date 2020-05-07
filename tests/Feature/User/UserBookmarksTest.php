<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\UserController;
use App\Models\Bookmark;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserBookmarksTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_bookmarks_page_is_displayed_only_for_this_user()
    {
        $user = factory(User::class)->create();
        $userGuest = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create();

        for ($i = 0; $i < $posts->count(); $i++) {
            $post = $posts->get($i);
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }


        // Author of the bookmark
        $response = $this
            ->actingAs($user)
            ->get(route(UserController::BOOKMARKS_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_OK);


        // Guest
        $response = $this
            ->actingAs($userGuest)
            ->get(route(UserController::BOOKMARKS_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);


        // Not registered user
        $response = $this
            ->get(route(UserController::BOOKMARKS_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_bookmarks_ordered_by_creation_date_desc()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create();

        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < $posts->count(); $i++) {
            $post = $posts->get($i);
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'created_at' => Carbon::now()->subDays($i),
            ]);

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }


        $response = $this
            ->actingAs($user)
            ->get(route(UserController::BOOKMARKS_PATH_NAME, $user->slugged_id));


        $this->assertSeeTextInOrderForCommonData($response, $data, PostListTest::DATA_FIELDS_FOR_CHECK);
    }
}
