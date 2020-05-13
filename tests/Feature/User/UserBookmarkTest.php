<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\BookmarkController;
use App\Models\Bookmark;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserBookmarkTest extends TestCase
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
            ->get(route(BookmarkController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_OK);


        // Guest
        $response = $this
            ->actingAs($userGuest)
            ->get(route(BookmarkController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);


        // Not registered user
        $response = $this
            ->get(route(BookmarkController::INDEX_PATH_NAME, $user->slugged_id));


        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_bookmarks_ordered_by_creation_date_desc()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create();

        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < $posts->count(); $i++) {
            $post = $posts->get($i);
            $bookmark = Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $bookmark->created_at = Carbon::now()->subDays($i);
            $bookmark->save();

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }


        $response = $this
            ->actingAs($user)
            ->get(route(BookmarkController::INDEX_PATH_NAME, $user->slugged_id));


        $this->assertSeeTextInOrderForCommonData($response, $data, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_can_be_bookmarked()
    {
        $post = factory(Post::class)->create();
        $user = factory(User::class)->create();

        // Add post to user bookmarks
        $response = $this->actingAs($user)
            ->postJson(route(BookmarkController::STORE_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(Response::HTTP_OK);

        // Check if the post is displayed on user bookmarks page
        $response = $this->actingAs($user)
            ->get(route(BookmarkController::INDEX_PATH_NAME, $user->slugged_id));

        $this->assertSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_post_cant_be_bookmarked_as_anonymous()
    {
        $post = factory(Post::class)->create();

        // Add post to user bookmarks
        $response = $this->postJson(route(BookmarkController::STORE_PATH_NAME), [
            'post_id' => $post->id,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_post_can_be_removed_from_bookmarks()
    {
        $post = factory(Post::class)->create([
            'created_at' => time() - 10000,
        ]);
        $user = factory(User::class)->create();

        Bookmark::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route(BookmarkController::DESTROY_PATH_NAME), [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(Response::HTTP_OK);

        // Check if the post is displayed on user bookmarks page
        $response = $this->actingAs($user)
            ->get(route(BookmarkController::INDEX_PATH_NAME, $user->slugged_id));

        $this->assertDontSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }
}
