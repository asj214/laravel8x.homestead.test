<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }
    //
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        if ($validator->fails()) return $this->respondError($validator->errors(), 400);

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->respond($user);

    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) return $this->respondFailedLogin();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->respondFailedLogin();
        }

        $token_name = $user->id.$user->email;

        return $this->respond([
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
        return $this->respondSuccess();
    }

}
