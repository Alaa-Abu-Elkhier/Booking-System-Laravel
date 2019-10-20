<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Image;

class UserController extends Controller
{
    //ٌRegister
        public function register(Request $request)
            {
                $validateData=$request->validate([
                    'name'            =>  'required|max:55',
                    'email'           =>  'email|required|unique:users',
                    'password'        =>  'required|confirmed',
                    'avatar'          =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',

                ]);
                $validateData['password']  =   bcrypt($request->password);
                $user=User::create($validateData);



                if($request->hasFile('avatar')){     //hasFile() to check the process not empty && avatar is the name of input
                    $avatar=$request->file('avatar');
                    $filename=time() . '.'  . $avatar->getClientOriginalExtension(); //we can use random() instead of time() these work to generate different name of avatar
                    Image::make($avatar)->resize(300,300)->save(public_path('uploads/avatars/'.$filename));

                    $user->avatar=$filename;
                    $user->validate_code=1234; //we will make it random number
                    $user->is_activated=0;
                    $user->save();

                return response()->json(['user'=>$user]);
            }
        }
    //verify User
        public function verify(Request $request){
            $validateData=$request->validate([

                'email'           =>  'required',
                'validate_code'   =>  'required'

            ]);
            //to verify this user exist on the system or not
            $user = User::where('email',$request->email)->first();
            if( !$user ){
                return response()->json(['message'=>'Wrong Email']);
        }
            if($user->validate_code != $request->validate_code){

            }
            $user->is_activated = 1;
            $user->validate_code= null;
            $user->save();
            $accessToken               =    $user-> createToken('authToken')->accessToken;
            return response()->json(['message'=>'Account Activated successfully','access_token'=>$accessToken]);



        }

    


//Resend Code
    public function resendCode (Request $request){
        $validateData=$request->validate([

            'email'  =>  'required',

        ]);

        $user = User::where('email',$request->email)->first();
        if( !$user ){
            return response()->json(['message'=>'Wrong Email']);
        }
        $user->validate_code = 1234;
        $user->save();
        return response()->json(['Code has been send Successfully']);
    }
}