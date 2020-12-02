<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use App\Transform\UserTransform;
use App\Models\User;


class AuthController extends Controller
{

    private $fractal;
    private $transform;

    public function __construct(Manager $fractal, UserTransform $userTransform)
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);

        $this->fractal = $fractal;
        $this->transform = $userTransform;
    }
    //
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        if ($validator->fails()) return respond_invalid($validator->errors());

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        return respond_success();

    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) return respond_invalid($validator->errors());

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return respond_error('email or password is invalid');
        }

        $token_name = $user->id.$user->email;

        return respond([
            'access_token' => $user->createToken($token_name)->plainTextToken,
            'token_type' => 'bearer'
        ]);

    }

    public function logout(Request $request){
        # 해당 유저의 전체 토큰 삭제
        $request->user()->tokens()->delete();
        # 접속한 토큰만 삭제
        // $request->user()->currentAccessToken()->delete();
        # 유저 정보 확인
        // auth()->user()->id
        return respond_success();
    }

    public function me(Request $request){
        $user = User::find($request->user()->id);
        $user = new Item($user, $this->transform);
        return respond($this->fractal->createData($user)->toArray());
    }

}
