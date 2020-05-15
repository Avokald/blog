<?php

use App\Models\PostLike;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = factory(\App\Models\Post::class, 3)->create();

        foreach ($posts as $post) {
            PostLike::create([
                'user_id' => UserSeeder::TEST_USER_ID,
                'post_id' => $post->id,
            ]);
        }

        $users = factory(\App\Models\User::class, 10)->create();
        foreach ($users as $user) {
            PostLike::create([
                'user_id' => $user->id,
                'post_id' => PostSeeder::TEST_PUBLISHED_ID,
            ]);
        }
    }
}
