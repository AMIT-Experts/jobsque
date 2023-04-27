<?php

namespace App\Http\Controllers;

use App\Models\favoraits;
use App\Models\jobs;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class FavoraitsController extends Controller
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
                'user_id'=>'required',
                'job_id'=>'required',

               ]);

        $job=jobs::where('id',$request->job_id)->first();

        $fav=new favoraits;
        $fav->user_id=$request->user_id;
        $fav->job_id=$request->job_id;
        $fav->like=true;
        $fav->image=$job->image;
        $fav->name=$job->name;
        $fav->location=$job->location;
        $fav->save();

       $job->favorites=$job->favorites+1;
       $job->update();
        return response(['status'=>true, 'data'=>$fav]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }
    }

    /**
     * Display the specified resource.
     */
    public function show_fav($id)
    {   try{
        $favs= favoraits::where('user_id',$id)->orderBy('created_at', 'desc')->get();
        return response(['status'=>true, 'data'=>$favs]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
     $fave=favoraits::find($id);
     $fave->delete();
     return response(['status'=>true, 'data'=>$fave]);
    }
}
