<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\PostController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_can_be_viewed_if_published()
    {
        $article = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
        ]);

        $user = factory(User::class)->create();

        $response = $this->get($article->getShowLink());

        $response->assertStatus(Response::HTTP_OK);

        $this->assertArticleData($response, $article);
    }

    public function test_article_in_draft_is_hidden()
    {
        $authorUser = factory(User::class)->create();

        $article = factory(Post::class)->create([
            'status' => Post::STATUS_DRAFT,
            'user_id' => $authorUser->id,
        ]);

        $response = $this
            ->actingAs($authorUser)
            ->get($article->getShowLink());

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertSeeText($article->title)
            ->assertSeeText($article->content)
            ->assertSeeText($article->created_at);


        $userObserver = factory(User::class)->create();

        $response = $this
            ->actingAs($userObserver)
            ->get($article->getShowLink());

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_article_redirects_if_only_id_provided_or_slug_incorrect()
    {
        $article = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
        ]);

        $response = $this->get(route(PostController::SHOW_PATH_NAME, $article->id));

        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get(route(PostController::SHOW_PATH_NAME, $article->id . '-'));

        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get(route(PostController::SHOW_PATH_NAME,
            $article->id . '-' . $article->slug . random_int(0, 100)));

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

    public function assertArticleData($response, $article)
    {
        $response
            ->assertSeeText($article->title)
            ->assertSeeText($article->content)
            ->assertSeeText($article->created_at);
    }

}
