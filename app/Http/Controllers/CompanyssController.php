<?php

namespace App\Http\Controllers;

use App\Models\companyss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CompanyssController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {try{

        $validate=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'website'=>'required',
            'about'=>'required',
            'location'=>'required',
           
           ]);

        $job=new companyss;
        if(isset($request['image'])){
            $filename=time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('company'),$filename);
            $path="public/jobs/$filename";
            $job->image=$path;
        }
        $job->name=$request->comp_name;
        $job->email=$request->comp_email;
        $job->website=$request->comp_website;
        $job->about=$request->about_comp;
        $job->location=$request->location;
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
    public function show(companyss $companyss)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(companyss $companyss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, companyss $companyss)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(companyss $companyss)
    {
        //
    }
}
