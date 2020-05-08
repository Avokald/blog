<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostController;
use App\Models\Bookmark;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostViewTest extends TestCase
{
    use RefreshDatabase;

    const DATA_FIELDS_FOR_CHECK = [
        'title',
        'content',
        'created_at',
    ];

    public function test_post_can_be_viewed_if_published()
    {
        $post = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
        ]);

        $user = factory(User::class)->create();

        $response = $this->get($post->getShowLink());

        $response->assertStatus(Response::HTTP_OK);

        $this->assertSeeTextForCommonDataFromModel($response, $post);
    }

    public function test_post_in_draft_is_hidden()
    {
        $authorUser = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'status' => Post::STATUS_DRAFT,
            'user_id' => $authorUser->id,
        ]);

        $response = $this
            ->actingAs($authorUser)
            ->get($post->getShowLink());

        $response
            ->assertStatus(Response::HTTP_OK);

        $this->assertSeeTextForCommonDataFromModel($response, $post);


        $userObserver = factory(User::class)->create();

        $response = $this
            ->actingAs($userObserver)
            ->get($post->getShowLink());

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_post_redirects_if_only_id_provided_or_slug_incorrect()
    {
        $post = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
        ]);

        $response = $this->get(route(PostController::SHOW_PATH_NAME, $post->id));

        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get(route(PostController::SHOW_PATH_NAME, $post->id . '-'));

        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get(route(PostController::SHOW_PATH_NAME,
            $post->id . '-' . $post->slug . random_int(0, 100)));

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function test_post_contains_category_data()
    {
        $category = factory(\App\Models\Category::class)->create();

        $post = factory(Post::class)->create([
            'category_id' => $category->id,
        ]);

        $response = $this->get($post->getShowLink());

        $response->assertSeeText($category->title);
        $response->assertSeeText(addcslashes($category->link, '/'));
        $response->assertSeeText(addcslashes($category->image, '/'));
    }

    public function test_post_has_bookmark_count()
    {
        $userCount = 5;
        $post = factory(Post::class)->create();

        $users = factory(User::class, $userCount)->create();

        foreach ($users as $user) {
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }

        $response = $this->get($post->getShowLink());

        $response->assertSeeText($userCount);


        $user2 = factory(User::class)->create();

        Bookmark::create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);


        $response = $this->get($post->getShowLink());

        $response->assertSeeText($userCount + 1);
    }
}
