<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;


class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $user = User::inRandomOrder()->first();
        $post = Post::inRandomOrder()->first();
        $post->increment('comments_count');

        return [
            //
            'commentable_id' => $post->id,
            'commentable_type' => 'posts',
            'user_id' => $user->id,
            'body' => $this->faker->text
        ];

    }
}
