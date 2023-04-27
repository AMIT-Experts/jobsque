<?php

namespace App\Http\Controllers;

use App\Models\education;
use App\Models\profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,)
    {try{

        $validate=Validator::make($request->all(),[
            'user_id'=>'required',
            'universty'=>'required',
            'title'=>'required',
            'start'=>'required',
            'end'=>'required',

           ]);


        $profile=profiles::where('user_id',$request->user_id)->first();
        $education=new  education;
        $education->universty=$request->universty;
        $education->title=$request->title;
        $education->start=$request->start;
        $education->end=$request->end;
        $education->user_id=$request->user_id;
        $education->profile_id=$profile->id;
        $education->save();
        return response()->json(['status'=>true,'data'=>$education]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {try{
       $education=education::where('user_id',$id)->orderBy('created_at', 'desc')->get();
       return response(['status'=>true, 'data'=>$education]);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {try{

        $validate=Validator::make($request->all(),[
            'id'=>'required',
            'universty'=>'required',
            'title'=>'required',
            'start'=>'required',
            'end'=>'required',

           ]);

       $education=education::where('id',$request->id)->first();
       $education->universty=$request->universty;
       $education->title=$request->title;
       $education->start=$request->start;
       $education->end=$request->end;
       $education->update();
       return response(['status'=>true, 'data'=>$education]);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],500);       }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, education $education)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(education $education)
    {
             //
    }
}
