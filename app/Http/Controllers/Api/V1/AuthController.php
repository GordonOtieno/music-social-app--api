<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try{
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
    
            $token = $user->createToken('user_token')->plainTextToken;
            return response()->json(['user'=> $user,'token' =>$token],200);

        } catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Smomehthing went wrong in authController.register'
            ]);
        }
      

    }

    public function login(LoginRequest $request){
        try{
            $user = User::where('email','=',$request->input('email'))->firstOrFail();
             if(Hash::check($request->input('password'),$user->password)){
                $token = $user->createToken('user_token')->plainTextToken;
                 return response()->json(['user'=> $user,'token' =>$token],200);
              }
             return response()->json([ 'error'=>'Email or password is wrong' ],200);

        } catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Smomehthing went wrong in authController.login'
            ]);
        }
    }

    public function logout(LogoutRequest $request){
        try{
            $user = User::findOrFail($request->input('user_id'));
            $user ->tokens()->delete();
            return response()->json('User Logged Out successfully',200);

        } catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Smomehthing went wrong in authController.logout'
            ]);
        }
    }
}
