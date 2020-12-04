<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transformers\BannerTransformer;
use App\Models\Banner;


class BannerController extends Controller
{

    private $transform = BannerTransformer::class;

    //
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index(Request $request) {

        $validate = Validator::make($request->all(), [
            'category_id' => ['required', 'integer']
        ]);

        if ($validate->fails()) return respond_invalid($validate->errors());

        $category_id = $request->input('category_id');
        $per_page = $request->input('per_page', 15);

        $banners = Banner::where('category_id', $category_id)->paginate($per_page);

        return respond(collection($banners, $this->transform, 'banners'));

    }

    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:4'],
        ]);

        if ($validate->fails()) return respond_invalid($validate->errors());

        $banner = new Banner;
        $banner->category_id = $request->input('category_id');
        $banner->title = $request->input('title');
        $banner->user_id = auth()->user()->id;
        $banner->link = $request->input('link');
        $banner->description = $request->input('description');
        $banner->save();

        return respond_success();

    }

}
