<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\profiles;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function user($id)
    {
        $user=User::where('id',$id)->first();
       return  response(['data'=> $user,'status'=>true],200);
    }

    public function login(Request $request){
        //validate fields
        try{
        $validate=Validator::make($request->all(),[
         'email'=>'required|email',
         'password'=>'required|min:6'
        ]);

        if($validate->fails()){
          $error=$validate->errors();
            return response()->jason(['status'=>false,
        'error'=>'error in data required'
        ],401);
           }


        $user=User::where('email',$request->email)->first();
    if(!$user){
        return response(['massage'=>'invalid email','status'=>false,],401);

    }
        //if(!$user || Auth::attempt($validate))
        if(!Auth::attempt($request->only(['email','password']))){
           return response(['massage'=>'wrong  password','status'=>false,],401);
        }


     //$user->tokens()->delete();
    $token=$user->createToken('API TOKEN')->plainTextToken;

      return response([
        'user'=>$user,
        'token'=>$token,
          'status'=>true

      ],200);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->messages(),


      ],401);       }
    }
    public function logout($email){
        //validate fields

      try{  $user=User::where('email',$email)->first();
        $user->session()->invalidate();
      // Auth::logout();


      return response([
         'massage'=>'loged out',
         'status'=>true,

      ],200);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }

    public function register(Request $request)
    {try{
        $validate=Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6'
           ]);


           if($validate->fails()){
            $error=$validate->errors();
            return response()->jason(['status'=>false,
        'errors'=>$validate->errors()
        ],401);
           }


        $user=new user;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=hash::make($request['password']);
        $user->otp=rand(1234,9999);
        $user->save();

         $profile=new profiles;
         $profile->user_id=$user->id;
         $profile->name=$request->name;
        $profile->email=$request->email;
        $profile->save();
         return response([
            'status'=>true,
            'data'=>$user,
            'profile'=>$profile,
            'token'=>$user->createToken('API TOKEN')->plainTextToken
         ]);
        }catch(\Exception $e){return response([
            'status'=>false,
            'massege'=>$validate->errors(),


          ],401);       }
    }

    /**
     * Display the specified resource.
     */
    public function show($email)
    {
        $user=User::where('email',$email)->first();
        return response()->json(['status'=>true,'data'=>$user->otp]);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
       try {
            $user = User::findOrFail($id);
            if(isset($request['name'])){
                $user->name = $request->name;
            }
            if(isset($request['password'])){
                $user->password = Hash::make($request['password']);
            }
            $user->update();

            return response()->json(['status'=>true, 'data'=>$user]);
        } catch (\Exception $e) {
            return response([
                'status'=>false,
                'message'=>$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */






}
