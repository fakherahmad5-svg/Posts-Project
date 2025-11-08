<?php
namespace App\Services;
namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService{

    public function register(RegisterRequest $request){
        $user = User::create($request->validated());
        return Responses::success('User Register Successfully', $user,201);
    }

    public function login(LoginRequest $request){

        $request->validated();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return Responses::fail('Invalid Credentials', 'invalid email or password',401);
        }
        $user = User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('token')->plainTextToken;
        return Responses::success('User Login Successfully', $token,200);
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return Responses::success('User Logout Successfully');
    }
    //public static function refreshToken(Request $request){

}
