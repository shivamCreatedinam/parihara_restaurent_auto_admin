<?php

namespace App\Http\Controllers;

use App\Models\DeliveryBoy;
use Illuminate\Http\Request;

class DeliveryBoyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request){



        $query=DeliveryBoy::where('status','!=','5');
        if($request->name !=""){
            $query = $query->where('name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        return view('restaurant/delivery_boy/delivery_boy_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        
        return view('restaurant/delivery_boy/add_delivery_boy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request){

        
        $request->validate([
            'name'=>'required',
            'mobile'=>'required|min:10|max:10|unique:users', 
            'email'=>'required|email|unique:users',   
            'password'=>'required', 
        ]);
        
        $resid = $request->session()->get('REST_ID');
        $getid = DeliveryBoy::max('id');
        if(!empty($getid)){
            $maxid = $getid;        
        }else{
            $maxid = 1;
        }
        $UID = "DB0".$maxid; 
        
        $model = new DeliveryBoy();
       
        $model->restaurant_id =$resid;
        $model->unique_id = $UID;
        $model->name = $request->post('name');
        $model->email = $request->post('email');
        $model->mobile = $request->post('mobile');
        $model->password = bcrypt($request->password);
        $model->temp_pass = $request->password;
        $model->verified =1;
        $model->created_date = date('Y-m-d H:i:s');
        $model->status = 1;
        $model->save();
        
        $request->session()->flash('message','Delivery Boy added successfully.');
        return redirect('restaurant/delivery-boy-list');
        
       
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryBoy $deliveryBoy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryBoy $deliveryBoy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryBoy $deliveryBoy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryBoy $deliveryBoy)
    {
        //
    }
}
