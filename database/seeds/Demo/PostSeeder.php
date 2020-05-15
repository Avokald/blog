<?php

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    const TEST_PUBLISHED_ID = 1;
    const TEST_DRAFT_ID = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = factory(Post::class)->create([
            'title' => 'testpost',
            'excerpt' => 'testexcerpt',
            'content' => 'testcontent #testtag ',
            'status' => Post::STATUS_PUBLISHED,
            'user_id' => 2,
            'category_id' => 1,
        ]);

        factory(Post::class)->create([
            'title' => 'testpost draft',
            'excerpt' => 'testexcerpt draft',
            'content' => 'testcontent #testtag draft',
            'status' => Post::STATUS_DRAFT,
            'user_id' => 2,
            'category_id' => 1,
        ]);

        factory(Post::class, 5)->create();

        $user = \App\Models\User::find(2);
        if ($user !== null) {
            $user->pinned_post_id = $post->id;
            $user->save();
        }

    }
}
