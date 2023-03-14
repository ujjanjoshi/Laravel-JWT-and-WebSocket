<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Todo;
use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\Object_;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Termwind\render;

class AuthController extends Controller
{
   public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|confirmed|min:6',
            'class'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $user=User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        return response()->json([
            'message'=>'User sucessfully register',
            'user'=>$user
        ],201);
   }
   public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'status' => 1,
                'message' => 'Invalid Credentials'
            ],404);
        }
//       return $request->password;
        $password = Hash::check($request->password, $user->password);
        if(!$password){
            return response()->json([
                'status' => 1,
                'message' => 'Invalid Credentials'
            ],404);
        }

        if(!$token=auth()->attempt($validator->validated())){
            return response()->json(['error'=>'Unauthorized'],401);
        }
        $token =  $this->createNewToken($token);
       $notifyupdate=User::all()->where('email', $request->email)->first();
       $notif=(string)$notifyupdate->notification;
       event(new \App\Events\Login($token['access_token'],$token['user']['id'],$notif));
       $notiflist=Notification::all();
       $orignalnot=array();
       foreach ($notiflist as $notflst){
           $s=explode(",",$notflst->viewed);
           if($notflst->class!=auth()->user()->class and $notflst->type=="specificclass"){

           }
           else{
               if(!in_array(auth()->user()->name, $s)){
                   if(auth()->user()->name==$notflst->username){
                       array_push($orignalnot,$notflst->description);
                   }
                   if($notflst->username==null and $notflst->class==auth()->user()->class){
                       array_push($orignalnot,$notflst->description);
                   }
                   if($notflst->type=="public"){
                       array_push($orignalnot,$notflst->description);
                   }
               }
           }

       }
return $token;
    }
    #creating token

    public function createNewToken($token){
        return [
           'access_token'=>$token,
           'token_type'=>'bearer',
           'expires_in'=>auth()->factory()->getTTL()*60,
           'user'=>auth()->user()
        ];
    }
    #profile
    public function profile(){
        return response()->json(auth()->user());
    }
    #logout
    public function logout(){
        Auth::logout();
        return "User Logout";
    }
}

