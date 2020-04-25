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

    public function testArticleCanBeViewedIfPublished()
    {
        $article = factory(Post::class)->create([
            'status' => Post::STATUS_PUBLISHED,
        ]);

        $user = factory(User::class)->create();

        $response = $this->get($article->getShowLink());

        $response->assertStatus(Response::HTTP_OK);

        $this->assertArticleData($response, $article);
    }

    public function testArticleInDraftIsHidden()
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

    public function testUserArticleRedirectsIfOnlyIdProvidedOrSlugIncorrect()
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

    public function assertArticleData($response, $article)
    {
        $response
            ->assertSeeText($article->title)
            ->assertSeeText($article->content)
            ->assertSeeText($article->created_at);
    }

}
