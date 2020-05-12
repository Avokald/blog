<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\UserController;
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
        $privateUser = factory(User::class)->create([
            'public' => false,
        ]);

        $response = $this
            ->actingAs($privateUser)
            ->get($privateUser->getPersonalPageLink());

        $this->assertCommonData($response, $privateUser);


        $publicUser = factory(User::class)->create([
            'public' => true,
        ]);

        $response = $this
            ->actingAs($publicUser)
            ->get($publicUser->getPersonalPageLink());

        $this->assertCommonData($response, $publicUser);
    }


    public function test_user_profile_can_be_viewed_if_public() {
        $user = factory(User::class)->create([
            'public' => true,
        ]);
        $userObserver = factory(User::class)->create();


        // Acting as guest
        $response = $this->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_OK);


        // Acting as another user
        $response = $this->actingAs($userObserver)
            ->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_user_profile_can_not_be_viewed_if_private() {
        $user = factory(User::class)->create([
            'public' => false,
        ]);
        $userObserver = factory(User::class)->create();

        // Acting as guest
        $response = $this->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_NOT_FOUND);


        // Acting as another user
        $response = $this->actingAs($userObserver)
            ->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_profile_redirects_if_only_id_provided_or_slug_incorrect()
    {
        $user = factory(User::class)->create();

        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->id));

        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get(route(UserController::SHOW_PATH_NAME, $user->id . '-'));

        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get(route(UserController::SHOW_PATH_NAME,
            $user->id . '-' . $user->slug . random_int(0, 100)));

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function test_user_profile_displays_only_published_posts()
    {
        $user = factory(User::class)->create();
        $data = $this->initializeCommonData(PostListTest::DATA_FIELDS_FOR_CHECK);

        for ($i = 0; $i < 5; $i++) {
            $post = factory(Post::class)->create([
                'status' => Post::STATUS_PUBLISHED,
                'user_id' => $user->id,
                'created_at' => time() - $i * 100,
            ]);

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
            $post = factory(Post::class)->create([
                'status' => Post::STATUS_DRAFT,
                'user_id' => $user->id,
                'created_at' => time() - $i * 100,
            ]);

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
            $post = factory(Post::class)->create([
                'status' => Post::STATUS_DRAFT,
                'user_id' => $user->id,
                'created_at' => time() - $i * 100,
            ]);

            $this->saveCommonData($data, $post, PostListTest::DATA_FIELDS_FOR_CHECK);
        }

        $response = $this
            ->actingAs($user)
            ->get(route(UserController::DRAFTS_PATH_NAME, $user->slugged_id));

        $this->assertSeeTextInOrderForCommonData($response, $data, PostListTest::DATA_FIELDS_FOR_CHECK);
    }

    public function assertCommonData($response, $user) {
        $response->assertStatus(Response::HTTP_OK)
            ->assertSeeText($user->name)
            ->assertDontSeeText($user->email);
    }
}
