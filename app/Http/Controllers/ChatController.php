<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\companyss;
use App\Models\notification;
use App\Models\profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use function PHPUnit\Framework\isNull;

class ChatController extends Controller
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
    public function store_user(Request $request)
    { try{

        $validate=Validator::make($request->all(),[
            'massage'=>'required',
            'user_id'=>'required',
            'comp_id'=>'required',
           ]);

        $chat=new chat;
        $chat->massage=$request->massage;
        $chat->user_id=$request->user_id;
        $chat->comp_id=$request->comp_id;
        $chat->sender_user='user';
        $chat->save();
        $notif=notification::where('comp_id',$request->comp_id)->where('user_id',$request->user_id)->first();
        if(!$notif){
            $comp=companyss::where('id',$request->comp_id)->first();
            $user=profiles::where('user_id',$request->user_id)->first();
          $notification=new notification;
        $notification->user_id=$request->user_id;
        $notification->comp_id=$request->comp_id;
        $notification->last_massage=$request->massage;
        $notification->comp_name=$comp->name;
          $notification->user_name=$user->name;
        $notification->save();
        }else{
            $notif->last_massage=$request->massage;
            $notif->update();
        }
        return response(['status'=>true, 'data'=>$chat]);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }

    }

    public function store_comp(Request $request)
    {
        try{


            $validate=Validator::make($request->all(),[
                'massage'=>'required',
                'user_id'=>'required',
                'comp_id'=>'required',

               ]);
            $chat=new chat;
        $chat->massage=$request->massage;
        $chat->user_id=$request->user_id;
        $chat->comp_id=$request->comp_id;
        $chat->sender_user='company';
        $chat->save();
        $notif=notification::where('comp_id',$request->comp_id)->where('user_id',$request->user_id)->first();

        if(!$notif){
            $comp=companyss::where('id',$request->comp_id)->first();
            $user=profiles::where('user_id',$request->user_id)->first();
            $notification=new notification;
          $notification->user_id=$request->user_id;
          $notification->comp_id=$request->comp_id;
          $notification->last_massage=$request->massage;
          $notification->comp_name=$comp->name;
          $notification->user_name=$user->name;
          $notification->save();
          }else{
              $notif->last_massage=$request->massage;
              $notif->update();
          }
        return response(['status'=>true, 'data'=>$chat]);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }

    }

    /**
     * Display the specified resource.
     */
    public function show_chat(Request $request)
    {try{

        $validate=Validator::make($request->all(),[

            'user_id'=>'required',
            'comp_id'=>'required',


           ]);
        $chat=chat::where('user_id',$request->user_id)->where('comp_id',$request->comp_id)->orderBy('created_at', 'desc')->get();
        return response(['status'=>true, 'data'=>$chat]);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
      ],401);       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chat $chat)
    {
        //
    }
}
