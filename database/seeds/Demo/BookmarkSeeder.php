<?php

use App\Models\Bookmark;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();
        $posts = \App\Models\Post::all();

        foreach ($users as $user) {
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $posts->random()->id,
            ]);
        }

        $posts = factory(\App\Models\Post::class, 3)->create();

        foreach ($posts as $post) {
            Bookmark::create([
                'user_id' => UserSeeder::TEST_USER_ID,
                'post_id' => $post->id,
            ]);
        }
    }
}
