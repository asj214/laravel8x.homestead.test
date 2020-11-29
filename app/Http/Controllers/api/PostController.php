<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Post;


class PostController extends Controller
{
    //
    public function index(){

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) {
            //
            return response()->json(['error' => 'Invalide Request Params']);
        }

        $post = new Post;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->save();

    }

    public function show($id){

        return response([
            'status' => 'Ok',
            'post' => Post::find($id)
        ], 200);

    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
            'body' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) {
            //
            return response()->json(['error' => 'Invalide Request Params']);
        }

        $post = Post::find($id);
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->save();

    }

    public function destroy($id){

    }

}
