<?php
namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;


class PostTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['user', 'comments', 'attachments'];
    protected $availableIncludes = [];

    public function transform(Post $post) {
        return [
            'id' => (int) $post->id,
            'user_id' => (int) $post->user_id,
            'user' => null,
            'title' => $post->title,
            'body' => $post->body,
            'attachments' => null,
            'comments_count'=> (int) ($post->comments_count == null ? 0 : $post->comments_count),
            'comments' => null,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at
        ];
    }

    public function includeUser(Post $post) {
        return $this->item($post->user, new UserTransformer);
    }

    public function includeComments(Post $post) {
        return $this->collection($post->comments, new CommentTransformer);
    }

    public function includeAttachments(Post $post) {
        return $this->collection($post->attachments, new AttachmentTransformer);
    }

}