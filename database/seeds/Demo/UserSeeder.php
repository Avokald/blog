<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const ADMIN_USER_ID = 1;
    const TEST_USER_ID = 2;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '$2y$10$EupfydU.p2ZgZXNjsC32N.Pz4AEt5OY5Zi.0jCQR30IyMHaNsnycO', // 123
        ]);

        factory(User::class)->create([
            'name' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => '$2y$10$EupfydU.p2ZgZXNjsC32N.Pz4AEt5OY5Zi.0jCQR30IyMHaNsnycO', // 123
        ]);

        factory(User::class, 5)->create();
    }
}
