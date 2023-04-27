<?php

namespace App\Http\Controllers;

use App\Models\applys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ApplysController extends Controller
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
    public function store(Request $request)
    { 

        try{
            
            $validate=Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required',
                'mobile'=>'required',
                'work_type'=>'required',
                'jobs_id'=>'required',
                'user_id'=>'required',
               
               
               ]);
            
            $apply=new applys;
             if(isset($request->cv_file)){
            $filename=time().'.'.$request->cv_file->getClientOriginalName();
            $request->cv_file->move(public_path('cv'),$filename);
            $path="public/cv/$filename";
            $apply->cv_file=$path;
             }
            
            $apply->name=$request->name;
            $apply->email=$request->email;
            $apply->mobile=$request->mobile;
            $apply->work_type=$request->work_type;
           if(isset($request->other_file)){
            $apply->other_file=$request->other_file;}else{$apply->other_file='';}
            $apply->jobs_id=$request->job_id;
            $apply->user_id=$request->user_id;
            $apply->reviewed=false;
            $apply->save();
            return response(['status'=>true, 'data'=>$apply]);

        }catch(\Exception $e){return response([
            'status'=>false,
            'massege'=>$validate->errors(),
          ],401);       }

       
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $education=applys::where('user_id',$id)->orderBy('created_at', 'desc')->get();
            return response(['status'=>true, 'data'=>$education]);
         
         }catch(\Exception $e){return response([
             'status'=>false,
             'massege'=>$e->getMessage(),
           ],500);       }
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(applys $applys)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {try{

        $apply=applys::where('id',$request->id)->first();
        $apply->reviewed=true;
        if($request->accept=='True'||$request->accept=='true'){
            $apply->accept=true;
        }else{
            $apply->accept=false;
        }
        
        $apply->update();
        return response(['status'=>true, 'data'=>$apply]);
    
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(applys $applys)
    {
        //
    }
}
