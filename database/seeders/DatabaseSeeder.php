<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        # create first user
        if (!User::where('email', 'abc214@abc.com')->first()) {
            User::factory()->create([
                'name' => 'sjahn',
                'email' => 'abc123@abc.com'
            ]);
        }
 
        # create dummy user
        User::factory(30)->create();

        // create post
        Post::factory(50)->create();

        // 1:N belong to
        // Post::factory()->count(3)->for(User::factory())->create();

        // randum user, post comment create
        Comment::factory(50)->create();


    }
}
