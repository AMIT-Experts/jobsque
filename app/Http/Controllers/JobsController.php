<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\jobs;
use App\Models\User;
use App\Models\profiles;
use Illuminate\Http\Request;

class JobsController extends Controller
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
    {try{

        $validate=Validator::make($request->all(),[
            'name'=>'required',
            'job_time_type'=>'required',
            'job_type'=>'required',
            'job_level'=>'required',
            'job_description'=>'required',
            'job_skill'=>'required',
            'comp_name'=>'required',
            'comp_email'=>'required',
            'comp_website'=>'required',
            'about_comp'=>'required',
            'location'=>'required',
            'salary'=>'required',

           ]);

        $job=new jobs;
        $job->name=$request->name;
        if(isset($request['image'])){
            $filename=time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('image'),$filename);
            $path="public/image/$filename";
            $job->image=$path;
        }

        $job->job_time_type=$request->job_time_type;
        $job->job_type=$request->job_type;
        $job->job_level=$request->job_level;
        $job->job_description=$request->job_description;
        $job->job_skill=$request->job_skill ;
        $job->comp_name=$request->comp_name;
        $job->comp_email=$request->comp_email;
        $job->comp_website=$request->comp_website;
        $job->about_comp=$request->about_comp;
        $job->favorites=0;
        $job->expired=false;
        $job->location=$request->location;
        $job->salary=$request->salary;
        $job->save();
        return response(['status'=>true, 'data'=>$job]);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }
    }

    /**
     * Display the specified resource.
     */

     public function showjobid($id)
    {
        try{
        $jobs=jobs::where('id',$id)->orderBy('created_at', 'desc')->get();
        return response(['status'=>true, 'data'=>$jobs]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    public function show()
    {
        try{
        $jobs=jobs::orderBy('created_at', 'desc')->get();
        return response(['status'=>true, 'data'=>$jobs]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    public function show_sugest($id)
    {   try{
        $user=profiles::where('user_id',$id)->first();
        $jobs=jobs::where('name',$user->intersted_work)->orderBy('created_at', 'desc')->get();
        $suggeted_jobs=jobs::where('name','like',"%".$user->intersted_work."%")->orderBy('created_at', 'desc')->get();
        return response(['status'=>true, 'data'=>$suggeted_jobs]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    public function search_jobs(Request $request)

    {
         try{

        $jobs=jobs::where('name','like',"%".$request->name."%")->orderBy('created_at', 'desc')->get();
        dd("sss");
        return response(['status'=>true, 'data'=>$jobs]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }


    public function filter_jobs(Request $request)
    {
        dd($request->all());
        try{
    // dd($request->all());

        $jobs=jobs::where('name','like',"%".$request->name."%")
        ->where('location','like',"%".$request->location."%")
        ->where('salary','like',"%".$request->salary."%")
        ->orderBy('created_at', 'desc')->get();
        return response(['status'=>true, 'data'=>$jobs]);


}catch(\Exception $e){return response([
    'status'=>false,
    'massege'=>$e->getMessage(),
  ],500);       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jobs $jobs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, jobs $jobs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jobs $jobs)
    {
        //
    }
}
