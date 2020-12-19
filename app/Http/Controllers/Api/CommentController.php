<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{

    private $transform = \App\Transformers\CommentTransformer::class;

    //
    public function index(Request $request) {

        $request->validate([
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer'
        ]);

        $c_type = $request->input('commentable_type');
        $c_id = $request->input('commentable_id');
        $per_page = $request->input('per_page', 15);

        $comments = Comment::where('commentable_type', $c_type)->where('commentable_id', $c_id)->paginate($per_page);
        
        return respond(collection($comments, $this->transform, 'comments'));

    }

    public function store(Request $request) {

        $request->validate([
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'body' => 'required',
        ]);

        $comment = new Comment;
        $comment->commentable_type = $request->input('commentable_type');
        $comment->commentable_id = $request->input('commentable_id');
        $comment->user_id = auth()->user()->id;
        $comment->body = $request->body;
        $comment->save();

        if ($comment->commentable_type == 'posts') {
            \App\Models\Post::find($comment->commentable_id)->increment('comments_count');
        }

        return respond_success();

    }

    public function destroy($id) {

        $comment = Comment::find($id);

        if (!$comment) return respond_forbidden();
        if ($comment->user_id != auth()->user()->id) return respond_unauthorized();

        if ($comment->commentable_type == 'posts') {
            \App\Models\Post::find($comment->commentable_id)->decrement('comments_count');
        }

        $comment->delete();

        return respond_success();

    }
}
