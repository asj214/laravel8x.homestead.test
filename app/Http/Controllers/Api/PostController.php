<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Transformers\PostTransformer;
use App\Models\Post;


class PostController extends Controller
{
    private $transform = PostTransformer::class;

    //
    public function index(){
        $posts = Post::paginate(15);
        return respond(collection($posts, $this->transform, 'posts'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) return respond_invalid($validator->errors());

        $post = new Post;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->save();

        return respond_created(item($post, $this->transform, 'post'));

    }

    public function show($id){
        return respond(item(Post::find($id), $this->transform, 'post'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) return respond_invalid($validator->errors());

        $post = Post::find($id);
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->save();

        return respond(item(Post::find($id), $this->transform, 'post'));
    }

    public function destroy($id){

    }

}
