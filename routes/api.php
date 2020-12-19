<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AttachmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => ['auth:sanctum']], function ($router) {
    # post
    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);

    # comment
    // Route::post('posts/{id}/comments', [PostController::class, 'comment_store']);
    // Route::delete('posts/{id}/comments/{comment_id}', [PostController::class, 'comment_destroy']);
    Route::get('comments', [CommentController::class, 'index']);
    Route::post('comments', [CommentController::class, 'store']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);

    # attachment
    Route::post('attachments', [AttachmentController::class, 'store']);

    # like
    Route::post('likes', [LikeController::class, 'store']);
    Route::delete('likes', [LikeController::class, 'destroy']);
});

# banners.index 는 토큰 없어도 되게끔
Route::get('banners', [BannerController::class, 'index']);
Route::post('banners', [BannerController::class, 'store']);