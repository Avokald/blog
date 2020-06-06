<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\UserController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User can view their own profile no matter of public settings
     */
    public function test_user_can_view_their_profile()
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user)
            ->get(route(UserController::SHOW_PATH_NAME, $user->slugged_id));

        $this->assertCommonData($response, $user);
    }


    public function test_user_profile_can_be_viewed() {
        $user = factory(User::class)->create();
        $userObserver = factory(User::class)->create();


        // Acting as guest
        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->slugged_id));

        $response->assertStatus(Response::HTTP_OK);


        // Acting as another user
        $response = $this->actingAs($userObserver)
            ->get(route(UserController::SHOW_PATH_NAME, $user->slugged_id));

        $response->assertStatus(Response::HTTP_OK);
    }

    // TODO Remove
//    public function test_user_profile_redirects_if_only_id_provided_or_slug_incorrect()
//    {
//        $user = factory(User::class)->create();
//
//        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->id));
//
//        $response->assertStatus(Response::HTTP_FOUND);
//
//        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->id . '-'));
//
//        $response->assertStatus(Response::HTTP_FOUND);
//
//        $response = $this->get(route(UserController::SHOW_PATH_NAME,
//            $user->id . '-' . $user->slug . random_int(0, 100)));
//
//        $response->assertStatus(Response::HTTP_FOUND);
//    }

    public function test_user_profile_displays_only_published_posts()
    {
        $user = factory(User::class)->create();
        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < 5; $i++) {
            $post = factory(Post::class)->make([
                'status' => Post::STATUS_PUBLISHED,
                'user_id' => $user->id,
            ]);
            $post->created_at = time() - $i * 100;
            $post->save();

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }

        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->slugged_id));

        $this->assertSeeTextInOrderForCommonData($response, $data, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_user_profile_hides_drafts()
    {
        $user = factory(User::class)->create();
        $userObserver = factory(User::class)->create();

        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < 5; $i++) {
            $post = factory(Post::class)->make([
                'status' => Post::STATUS_DRAFT,
                'user_id' => $user->id,
            ]);
            $post->created_at = time() - $i * 100;
            $post->save();

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }

        // Anon
        $response = $this->get(route(UserController::DRAFTS_PATH_NAME, $user->slugged_id));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Registered user
        $response = $this
            ->actingAs($userObserver)
            ->get(route(UserController::DRAFTS_PATH_NAME, $user->slugged_id));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_profile_displays_drafts_if_author()
    {
        $user = factory(User::class)->create();
        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < 5; $i++) {
            $post = factory(Post::class)->make([
                'status' => Post::STATUS_DRAFT,
                'user_id' => $user->id,
            ]);
            $post->created_at = time() - $i * 100;
            $post->save();

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }

        $response = $this
            ->actingAs($user)
            ->get(route(UserController::DRAFTS_PATH_NAME, $user->slugged_id));

        $this->assertSeeTextInOrderForCommonData($response, $data, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_user_profile_displays_pinned_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
            'user_id' => $user->id,
        ]);
        $user->pinned_post_id = $post->id;
        $user->save();


        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->slugged_id));

        $response->assertSeeTextInOrder(['pinned_post', $post->title, $post->excerpt]);
    }

    public function test_user_profile_hides_pinned_draft_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'status' => Post::STATUS_DRAFT,
            'user_id' => $user->id,
        ]);

        $user->pinned_post_id = $post->id;
        $user->save();

        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->slugged_id));

        $this->assertDontSeeTextForCommonDataFromModel($response, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function test_user_profile_displays_comments()
    {
        $this->seed(\PostSeeder::class);
        $this->seed(\UserSeeder::class);
        $this->seed(\CommentSeeder::class);

        $user = $user = factory(User::class)->create();
        $data = [
            'content' => [],
            'post_title' => [],
            'created_at' => [],
        ];
        $posts = factory(Post::class, 3)->create([
            'status' => Post::STATUS_PUBLISHED,
            'user_id' => $user->id,
        ]);

        foreach ($posts as $key => $post) {
            $comment = factory(Comment::class)->create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $comment->created_at = time() - ($key * 100);
            $comment->save();

            $data['content'][] = $comment->content;
            $data['post_title'][] = $post->title;
            $data['created_at'][] = $comment->created_at;
        }

        $response = $this->get(route(UserController::COMMENTS_PATH_NAME, $user->slugged_id));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertSeeTextInOrderForCommonData($response, $data, ['content', 'created_at']);
    }





    public function assertCommonData($response, $user) {
        $response->assertStatus(Response::HTTP_OK)
            ->assertSeeText($user->name)
            ->assertDontSeeText($user->email);
    }
}
