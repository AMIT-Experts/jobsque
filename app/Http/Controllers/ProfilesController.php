<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\portofolios;
use App\Models\profiles;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfilesController extends Controller
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
    public function store_main(Request $request,$id)
    {try{
        $validate=Validator::make($request->all(),[
            'intersted_work'=>'required',
            'offline_place'=>'required',
            'remote_place'=>'required'
           ]);


        $profiles= profiles::where('user_id',$id)->first();
        $profiles->intersted_work=$request->intersted_work;
        $profiles->offline_place=$request->offline_place;
        $profiles->remote_place=$request->remote_place;
        $profiles->save();
        return response(['status'=>true, 'data'=>$profiles]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }
    }


    public function edit_details(Request $request,$id)
    {try{
        $validate=Validator::make($request->all(),[
            'personal detailes'=>'required',

           ]);
        $profiles= profiles::where('user_id',$id)->first();
        $profiles['personal detailes']=$request['personal detailes'];
        $profiles->update();

        return response(['status'=>true, 'data'=>$profiles]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }
    }

    public function edit_profile(Request $request,$id)
    {try{
        $validate=Validator::make($request->all(),[
            'bio'=>'required',
            'address'=>'required',
            'mobile'=>'required',
           ]);


        $profiles= profiles::where('user_id',$id)->first();
        if(!$profiles){
            return response(['status'=>true, 'data'=>'wrong user id']);
        }
        $profiles->bio=$request->bio;
        $profiles->address=$request->address;
        $profiles->mobile=$request->mobile;
        $profiles->update();

        return response(['status'=>true, 'data'=>$profiles]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }
    }
    public function edit_profile_lang(Request $request,$id)
    {try{

        $validate=Validator::make($request->all(),[
            'language'=>'required',

           ]);

        $profiles= profiles::where('user_id',$id)->first();
        if(!$profiles){
            return response(['status'=>true, 'data'=>'wrong user id']);
        }
        $profiles->language=$request->language;
        $profiles->update();

        return response(['status'=>true, 'data'=>$profiles]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],500);       }
    }

    public function get_portofolio($id)
    {try{
        $portofolios= portofolios::where('user_id',$id)->orderBy('created_at', 'desc')->get();
        if(!$portofolios){
            return response(['status'=>true, 'data'=>'wrong user id']);
        }

        return response(['status'=>true, 'data'=>$portofolios]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    public function add_portofolio(Request $request,$id)
    {try{
        if(isset($request->cv_file)){
        $filename=time().'.'.$request->cv_file->getClientOriginalName();
        $request->cv_file->move(public_path('cv'),$filename);
        $path="public/cv/$filename";}

        $profile=profiles::where('user_id',$id)->first();
        if(!$profile){
            return response(['status'=>true, 'data'=>'wrong user id']);
        }
        $portofolios=new portofolios;
        $portofolios->name=$request->name;
        $portofolios->user_id=$id;
        $portofolios->profile_id=$profile->id;
        $portofolios->cv_file=$path;
        $portofolios->save();


        return response(['status'=>true, 'data'=>$portofolios]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    public function delete_portofolio(Request $request,$id)
    {try{
         $portofolios= portofolios::where('user_id',$id)->first();
         if(!$portofolios){
            return response(['status'=>true, 'data'=>'wrong user id']);
        }
        $portofolios->delete();

        return response(['status'=>true,'massage'=>'portofolio deleted', 'data'=>$portofolios]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    public function edit_portofolio(Request $request,$id)
    {try{

        $validate=Validator::make($request->all(),[
            'name'=>'required',

           ]);

        $portofolios= portofolios::where('user_id',$id)->first();
        if(!$portofolios){
            return response(['status'=>true, 'data'=>'wrong user id']);
        }

        $portofolios->name=$request->name;

       if(isset($request['cv_file'])){
        $filename=time().'.'.$request->cv_file->getClientOriginalName();
        $request->cv_file->move(public_path('cv'),$filename);
        $path="public/cv/$filename";
        $portofolios->cv_file=$path;
       }
        $portofolios->update();

        return response(['status'=>true, 'data'=>$portofolios]);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],500);       }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $profiles= profiles::where('user_id',$id)->first();
        if(!$profiles){
            return response(['status'=>true, 'data'=>'wrong user id']);
        }
        return response(['status'=>true, 'data'=>$profiles]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(profiles $profiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, profiles $profiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(profiles $profiles)
    {
        //
    }
}
