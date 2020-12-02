<?php
namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;


class PostTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['user'];
    protected $availableIncludes = [];

    public function transform(Post $post) {
        return [
            'id' => (int) $post->id,
            'user_id' => (int) $post->user_id,
            'user' => null,
            'title' => $post->title,
            'body' => $post->body,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at
        ];
    }

    public function includeUser(Post $post) {
        return $this->item($post->user, new UserTransformer);
    }

}