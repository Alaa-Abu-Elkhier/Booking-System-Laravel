<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Hash;

class ForgotPasswordController extends Controllers
{
   public function forgotPassword(Request $request){

       $user = User::whereEmail($request->email)->first();
       if(!$user){
        return response(['message'=>'user not found']);
       };

       $user->validate_code = mt_rand(1000, 9999);
       $user->save();
       return response('Code has been send Successfully');
   }

   public function resetPasswords(Request $request){

       $validatedata = $request->validate([
        'email'=>'required',
        'validate_code'=> 'required',
        'password'=>'required|confirmed' 
         ]);

        $user = User::whereEmail($request->email)->first();

        if( !$user ){
            return response('wrong email');
          };
          if($user->validate_code != $request->validate_code){
            return response('the code is wrong');
          }
        
        $user->password = Hash::make($request->password);
        $user->validate_code = null;
        $user->is_activated == 0 ? $user->is_activated = 1 : 0;
        $user->save();
        return response('Password has been changed successfully');
   }
}


