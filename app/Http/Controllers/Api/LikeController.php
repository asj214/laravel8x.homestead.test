<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;


class LikeController extends Controller
{
    //
    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'likeable_type' => ['required', 'string'],
            'likeable_id' => ['required', 'integer']
        ]);

        $likeable_type = $request->input('likeable_type');
        $likeable_id = $request->input('likeable_id');
        $user_id = auth()->user()->id;

        $terms = [
            ['likeable_type', '=', $likeable_type],
            ['likeable_id', '=', $likeable_id],
            ['user_id', '=', $user_id]
        ];

        # 중복 좋아요 허용 안함
        if (Like::where($terms)->exists()) return respond_invalid('Already Exists');

        Like::insert([
            'likeable_type' => $likeable_type,
            'likeable_id' => $likeable_id,
            'user_id' => $user_id
        ]);

        if ($likeable_type == 'posts') {
            \App\Models\Post::find($likeable_id)->increment('likes_count');
        }

        return respond_success();

    }

    public function destroy(Request $request) {

        $validate = Validator::make($request->all(), [
            'likeable_type' => ['required', 'string'],
            'likeable_id' => ['required', 'integer']
        ]);

        $likeable_type = $request->input('likeable_type');
        $likeable_id = $request->input('likeable_id');
        $user_id = auth()->user()->id;

        $terms = [
            ['likeable_type', '=', $likeable_type],
            ['likeable_id', '=', $likeable_id],
            ['user_id', '=', $user_id]
        ];

        if (Like::where($terms)->doesntExist()) return respond_forbidden();

        Like::where($terms)->delete();

        if ($likeable_type == 'posts') {
            \App\Models\Post::find($likeable_id)->decrement('likes_count');
        }

        return respond_success();

    }

}
