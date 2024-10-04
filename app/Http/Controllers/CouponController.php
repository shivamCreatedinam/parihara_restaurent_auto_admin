<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query =Coupon::where('status','!=',5);
    
        if($request->coupon_code !=""){
            $query = $query->where('coupon_code',$request->coupon_code);
        }
        if($request->coupon_type !=""){
            $query = $query->where('discount_type',$request->coupon_type);
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('valid_from','>=',$request->from_date)->whereDate('expires_on','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] =$query; 
        return view('admin/coupon/coupon_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['user']=User::where('status','!=',5)->orderBy('id','DESC')->get();
        return view('admin/coupon/add_coupon',$data);
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
            'coupon_code'=>'required',
            'coupon_type'=>'required',
            'discount'=>'required',
            'user_type'=>'required',
            'coupon_start_from'=>'required',
            'coupon_expires_on'=>'required',
            'description'=>'required',
        ]);
        
        $model = new Coupon();
        $model->coupon_code = $request->post('coupon_code');
        $model->discount = $request->post('discount');
        $model->discount_type = $request->post('coupon_type');
        $model->user_type = $request->post('user_type');
        $model->description = $request->post('description');
        $model->valid_from = $request->post('coupon_start_from');
        $model->expires_on = $request->post('coupon_expires_on');
        $model->status = 1;
        if($model->save()){

            
            if($request->post('user_type') == 'Selected-User'){
                $count = sizeof($request->post('selected_user_id'));
                for ($i=0; $i < $count; $i++) { 
                    DB::table('coupon_selected_users')->insert(array(
                        'user_id'=>$request->post('selected_user_id')[$i],
                        'coupon_id'=>$model->id,
                    ));
                }
            }


        $request->session()->flash('message','Coupon added Successfully.');
        return redirect('sysadmin/coupons');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon,$id="")
    {
        if($id !=''){
            $data['user']=User::where('status','!=',5)->orderBy('id','DESC')->get();
            $data['data'] = Coupon::where(['id'=>$id])->first();
            return view('admin/coupon/edit_coupon',$data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'coupon_code'=>'required',
            'coupon_type'=>'required',
            'discount'=>'required',
            'user_type'=>'required',
            'coupon_start_from'=>'required',
            'coupon_expires_on'=>'required',
            'description'=>'required',
            'hiddenid'=>'required',
        ]);
        
       if($request->post('hiddenid') > 0){
        $model = Coupon::find($request->post('hiddenid'));
        $model->coupon_code = $request->post('coupon_code');
        $model->discount = $request->post('discount');
        $model->discount_type = $request->post('coupon_type');
        $model->user_type = $request->post('user_type');
        $model->description = $request->post('description');
        $model->valid_from = $request->post('coupon_start_from');
        $model->expires_on = $request->post('coupon_expires_on');
        $model->status =  $request->post('status');
        if($model->save()){

          
            DB::table('coupon_selected_users')->where('coupon_id',$request->post('hiddenid'))->delete();
            if($request->post('user_type') == 'Selected-User'){
                $count = sizeof($request->post('selected_user_id'));
                for ($i=0; $i < $count; $i++) { 
                    DB::table('coupon_selected_users')->insert(array(
                        'user_id'=>$request->post('selected_user_id')[$i],
                        'coupon_id'=>$request->post('hiddenid'),
                    ));
                }
            }


        $request->session()->flash('message','Coupon updated Successfully.');
        return redirect('sysadmin/coupons');
        }
       }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id="")
    {
        if($id > 0  AND $id !=''){
            $model = Coupon::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Coupon Deleted Successfully.');
            return redirect('sysadmin/coupons');
        }
    }
}
