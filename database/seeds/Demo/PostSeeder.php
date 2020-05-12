<?php

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class)->create([
            'title' => 'mypost',
            'excerpt' => 'myexcerpt',
            'content' => 'mycontent #mytag ',
            'status' => Post::STATUS_PUBLISHED,
            'user_id' => 1,
            'category_id' => 1,
        ]);
        factory(Post::class)->create([
            'title' => 'mypost',
            'excerpt' => 'myexcerpt',
            'content' => 'mycontent #mytag ',
            'status' => Post::STATUS_DRAFT,
            'user_id' => 1,
            'category_id' => 1,
        ]);
        factory(Post::class, 5)->create();
    }
}
