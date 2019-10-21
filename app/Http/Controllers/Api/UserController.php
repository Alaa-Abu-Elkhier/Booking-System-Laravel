<?php

namespace App\Http\Controllers\Api;
use App\User;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

  //log in
  public function login(Request $request){
    $loginData = $request->validate([
      'email'=>'email|required',
      'password'=>'required'
       ]);
    if(!auth()->attempt($loginData)) {
    return response(['message'=>'Invalid credentials']) ;
    };
    $accessToken = auth()->user()->createToken('authToken')->accessToken;
    return response(['user'=>(auth()->user()), 'accessToken'=>$accessToken]);
  }

  //forgetting password, Send code to email
  public function forgotPassword(Request $request){
       $user = User::whereEmail($request->email)->first();
       if(!$user){
        return response(['message'=>'user not found']);
       };

       $user->validate_code = mt_rand(1000, 9999);
       $user->save();
       return response(['message'=>'Code has been send Successfully']);
   }

  //reset new password and validate code
  public function resetPasswords(Request $request){
      $validatedata = $request->validate([
      'email'=>'required',
      'validate_code'=> 'required',
      'password'=>'required|confirmed'
        ]);

      $user = User::whereEmail($request->email)->first();

      if( !$user ){
          return response(['message'=>'wrong email']);
        };
        if($user->validate_code != $request->validate_code){
          return response(['message'=>'the code is wrong']);
        }

      $user->password = Hash::make($request->password);
      $user->validate_code = null;
      $user->is_activated == 0 ? $user->is_activated = 1 : 0;
      $user->save();
      return response(['message'=>'Password has been changed successfully']);
   }
}


