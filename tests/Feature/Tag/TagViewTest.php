<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TagViewTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const DATA_FIELDS_FOR_CHECK = [
        'title',
    ];

    public function test_tag_page_displays_information()
    {
        $tag = factory(Tag::class)->create();


        $response = $this->get($tag->link);


        $response->assertStatus(Response::HTTP_OK);

        $response->assertSeeText(addcslashes($tag->link, '/'));
        $this->assertSeeTextForCommonDataFromModel($response, $tag);
    }

    public function test_tag_page_displays_only_published_posts()
    {
        $tag = factory(Tag::class)->create();

        $postCommonData = ['title', 'created_at'];

        $postsData = $this->initializeCommonData($postCommonData);

        $notDisplayedData = $this->initializeCommonData($postCommonData);

        for ($i = 5; $i > 0; $i--) {
            $post = factory(Post::class)->create([
                'content' =>  $this->faker->text . '#' . $tag->title . ' ' . $this->faker->text,
                'created_at' => time() + ($i * 10),
            ]);
            $this->saveCommonData($postsData, $post, $postCommonData);
        }

        for ($i = 10; $i > 5; $i--) {
            $post = factory(Post::class)->create([
                'content' => $this->faker->text . '#' . $tag->title . ' ' . $this->faker->text,
                'status' => Post::STATUS_DRAFT,
                'created_at' => time() + ($i * 100),
            ]);

            $this->saveCommonData($notDisplayedData, $post, $postCommonData);
        }


        $response = $this->get($tag->link);


        $this->assertSeeTextInOrderForCommonData($response, $postsData, $postCommonData);

        $this->assertDontSeeTextInOrderForCommonData($response, $notDisplayedData,$postCommonData);
    }
}
