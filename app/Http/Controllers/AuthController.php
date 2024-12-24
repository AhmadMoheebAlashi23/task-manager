<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(Request $request){
        $valedated=$request->validate([
            "email"=> "required|email",
            "password"=> "required",

         ]);

         if(! Auth ::attempt($valedated)){
                return response()->json([
                    "message" =>"Login information invaled ! "
            ],401);
         }

         $user=User::where('email',$valedated['email'])->first();
         return response()->json([
            'access_token'=>$user->createToken('api_token')->plainTextToken,
            'token_type'=>"Bearer"
         ]);

    }

    public function register(Request $request){
        $valedated=$request->validate([
            "name"=> "required|max:255",
            "email"=> "required|min:3|email|unique:users,email",
            "password"=> "required|confirmed|min:3",
         ]);
         $valedated['password']=Hash::make('',$valedated['password']);

         $user=User::create($valedated);

         return response()->json([
            'data'=>$user,
            'access_token'=>$user->createToken('api_token')->plainTextToken,
            'token_type'=>"Bearer"
         ],201);
    }

    public function logout(){

    }



}
