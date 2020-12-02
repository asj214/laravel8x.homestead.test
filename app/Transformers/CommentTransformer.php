<?php
namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;


class CommentTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['user'];
    protected $availableIncludes = [];

    public function transform(Comment $comment) {
        return [
            'id' => (int) $comment->id,
            'commentable_id' => (int) $comment->id,
            'commentable_type' => $comment->commentable_type,
            'user_id' => (int) $comment->user_id,
            'user' => null,
            'body' => $comment->body,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at
        ];
    }

    public function includeUser(Comment $comment) {
        return $this->item($comment->user, new UserTransformer);
    }

}