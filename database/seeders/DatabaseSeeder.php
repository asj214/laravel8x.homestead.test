<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Comment;
use App\Models\Attachment;
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

        # dummy
        # banner
        Banner::factory(15)->create()->each(function($banner) {
            Attachment::factory()->state([
                'attachment_type' => 'banners',
                'attachment_id' => $banner->id,
                'user_id' => $banner->user_id
            ])->create();
        });

        # user -> posts -> comments:attachments
        User::factory(10)->create()->each(function($user) {

            // default post
            Post::factory(1)->state([
                'category_id' => 1,
                'user_id' => $user->id
            ])->create()->each(function($post) {

                $per = 2;

                Comment::factory($per)->state([
                    'commentable_type' => 'posts',
                    'commentable_id' => $post->id
                ])->create();

                $post->increment('comments_count', $per);

            });

            // card
            Post::factory(2)->state([
                'category_id' => 2,
                'user_id' => $user->id
            ])->create()->each(function($post) {

                Attachment::factory()->state([
                    'attachment_type' => 'posts',
                    'attachment_id' => $post->id,
                    'user_id' => $post->user_id
                ])->create();

                $per = 3;

                Comment::factory(3)->state([
                    'commentable_type' => 'posts',
                    'commentable_id' => $post->id
                ])->create();

                $post->increment('comments_count', $per);

            });

        });

        // randum user, post comment create
        // Comment::factory(30)->create();

    }
}
