<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;


class PostController extends ApiController
{
    //
    public function index(){
        $posts = Post::paginate(15);
        return $this->respond($posts);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) return $this->respondError($validator->errors(), 400);

        $post = new Post;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->save();

        return $this->respondCreated($post);

    }

    public function show($id){
        return $this->respond(Post::find($id));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) return $this->respondError($validator->errors(), 400);

        $post = Post::find($id);
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->save();

        return $this->respond($post);
    }

    public function destroy($id){

    }

}
