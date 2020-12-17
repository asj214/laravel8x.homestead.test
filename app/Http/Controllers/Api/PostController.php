<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Transformers\PostTransformer;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;


class PostController extends Controller
{
    private $transform = PostTransformer::class;
    private $categories = [];

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index']]);
        $this->categories = config('constants.categories')[CATEGORY_POST];
    }

    public function index(Request $request){

        $category_id = $request->input('category_id');
        $per_page = $request->input('per_page', 15);

        $posts = Post::when($category_id, function($query, $category_id){
            return $query->where('category_id', $category_id);
        })->paginate($per_page);

        return respond(collection($posts, $this->transform, 'posts'));

    }

    public function store(Request $request){

        $validate = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validate->fails()) return respond_invalid($validate->errors());

        $post = new Post;
        $post->category_id = $request->category_id;
        $post->user_id = auth()->user()->id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return respond_created(item($post, $this->transform, 'post'));

    }

    public function show($id) {
        return respond(item(Post::find($id), $this->transform, 'post'));
    }

    public function update(Request $request, $id){

        $validate = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validate->fails()) return respond_invalid($validate->errors());

        $post = Post::find($id);
        $post->category_id = $request->category_id;
        $post->user_id = auth()->user()->id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return respond(item(Post::find($id), $this->transform, 'post'));
    }

    public function destroy($id){

        $post = Post::find($id);

        if ($post->user_id != auth()->user()->id) return respond_unauthorized();

        $post->delete();

        return respond_success();
    }

    public function comment_store(Request $request, $id) {

        $validate = Validator::make($request->all(), [
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validate->fails()) return respond_invalid($validate->errors());

        $post = Post::find($id);

        if ($post) {
            $comment = new Comment;
            $comment->commentable_id = $id;
            $comment->commentable_type = 'posts';
            $comment->user_id = auth()->user()->id;
            $comment->body = $request->body;
            $comment->save();
    
            $post->increment('comments_count');

            return respond(item($post, $this->transform, 'post'));

        }

        return respond_forbidden();

    }

    public function comment_destroy($id, $comment_id) {

        $post = Post::find($id);
        $comment = Comment::find($comment_id);

        if (!$post || !$comment) return respond_forbidden();
        if ($comment->user_id != auth()->user()->id) return respond_unauthorized();

        $comment->delete();
        $post->decrement('comments_count');

        return respond(item($post, $this->transform, 'post'));

    }

    public function like($id) {

        if (Post::where('id', $id)->doesntExist()) {
            return respond_forbidden();
        }

        $exists = Like::where([
            ['likeable_type', '=', 'posts'],
            ['likeable_id', '=', $id],
            ['user_id', '=', auth()->user()->id]
        ])->doesntExist();

        $post = Post::find($id);

        if ($exists) {
            Like::insert([
                'likeable_type' => 'posts',
                'likeable_id' => $id,
                'user_id' => auth()->user()->id
            ]);
            $post->increment('likes_count');
        }

        return respond(item($post, $this->transform, 'post'));

    }

    public function unlike($id) {

        if (Post::where('id', $id)->doesntExist()) {
            return respond_forbidden();
        }

        $post = Post::find($id);
        $exists = Like::where([
            ['likeable_type', '=', 'posts'],
            ['likeable_id', '=', $id],
            ['user_id', '=', auth()->user()->id]
        ])->exists();

        if ($exists) {
            $post->decrement('likes_count');
        }

        return respond(item($post, $this->transform, 'post'));

    }

}
