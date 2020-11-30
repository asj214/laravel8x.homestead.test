<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;


class AuthController extends Controller
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

        if ($validator->fails()) {
            //
            return response()->json(['error' => 'Something is wrong with Your Request']);
        }

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        return response([
            'status' => 'Ok',
            'data' => $user
        ], 200);

    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:4'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token_name = $user->id.$user->email;

        return response([
            'status' => 'Ok',
            'access_token' => $user->createToken($token_name)->plainTextToken,
            'token_type' => 'bearer',
        ], 200);

    }

    public function logout(Request $request){
        # 해당 유저의 전체 토큰 삭제
        $request->user()->tokens()->delete();
        # 접속한 토큰만 삭제
        // $request->user()->currentAccessToken()->delete();
        # 유저 정보 확인
        // auth()->user()->id
        return response([
            'status' => 'Ok'
        ], 200);
    }

}
