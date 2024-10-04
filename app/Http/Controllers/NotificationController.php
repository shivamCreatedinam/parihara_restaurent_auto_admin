<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['user']=User::where('status','!=',5)->where('user_type','USER')->orderBy('id','DESC')->get();
        $query=Notification::where('status','!=','5');
        if($request->message !=""){
            $query = $query->where('message','LIKE','%'.$request->message.'%');
        }
        
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_at','>=',$request->from_date)->whereDate('created_at','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        return view('admin/notification/notification_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['user']=User::where('status','!=',5)->where('user_type','USER')->orderBy('id','DESC')->get();
        return view('admin/notification/add_notification',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_type'=>'required',
            'message'=>'required',
        ]);
        
        $model = new Notification();
        $model->send_by = "ADMIN";
        $model->user_type = $request->post('user_type');
        $model->message = $request->post('message');
        $model->status = 1;
        if($model->save()){

           
            if($request->post('user_type') == 'Selected-User'){
                $count = sizeof($request->post('selected_user_id'));
                for ($i=0; $i < $count; $i++) { 
                    DB::table('notification_selected_users')->insert(array(
                        'user_id'=>$request->post('selected_user_id')[$i],
                        'notification_id'=>$model->id,
                    ));
                }
            }


        $request->session()->flash('message','Notification added Successfully.');
        return redirect('sysadmin/notification');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification,$id="")
    {
        if($id !=''){
            $data['user']=User::where('status','!=',5)->orderBy('id','DESC')->get();
            $data['data'] = Notification::where(['id'=>$id])->first();
            return view('admin/notification/edit_notification',$data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'user_type'=>'required',
            'message'=>'required',
            'hiddenid'=>'required',
        ]);
        
       if($request->post('hiddenid') > 0){
        $model = Notification::find($request->post('hiddenid'));
        $model->user_type = $request->post('user_type');
        $model->message = $request->post('message');
        $model->status =  $request->post('status');
        if($model->save()){

         
            DB::table('notification_selected_users')->where('notification_id',$request->post('hiddenid'))->delete();
            if($request->post('user_type') == 'Selected-User'){
                $count = sizeof($request->post('selected_user_id'));
                for ($i=0; $i < $count; $i++) { 
                    DB::table('notification_selected_users')->insert(array(
                        'user_id'=>$request->post('selected_user_id')[$i],
                        'notification_id'=>$request->post('hiddenid'),
                    ));
                }
            }


        $request->session()->flash('message','Notification updated Successfully.');
        return redirect('sysadmin/notification');
        }
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id="")
    {
        if($id > 0  AND $id !=''){
            $model = Notification::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Notification Deleted Successfully.');
            return redirect('sysadmin/notification');
        }
    }
}
