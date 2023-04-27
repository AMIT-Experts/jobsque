<?php

namespace App\Http\Controllers;

use App\Models\experince;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ExperinceController extends Controller
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
            'user_id'=>'required',
            'postion'=>'required',
            'type_work'=>'required',
            'comp_name'=>'required',
            'location'=>'required',
            'start'=>'required',
           ]);

        $exp=new experince;
        $exp->user_id=$request->user_id;
        $exp->postion=$request->postion;
        $exp->type_work=$request->type_work;
        $exp->comp_name=$request->comp_name;
        $exp->location=$request->location;
        $exp->start=$request->start;
        $exp->save();


        return response(['status'=>true, 'data'=>$exp]);   //

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
        $exp=experince::where('user_id',$id)->orderBy('created_at', 'desc')->get();
       return response(['status'=>true, 'data'=>$exp]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {try{
        $exp=experince::where('id',$id)->first();
        $date= Carbon::now()->format('Y-m');
        $exp->end=$date;
        $exp->update();
        return response(['status'=>true, 'data'=>$exp]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, experince $experince)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(experince $experince)
    {
        //
    }
}
