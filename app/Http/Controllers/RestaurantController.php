<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Order;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request){

        $query=Restaurant::where('status','!=','5');
        if($request->name !=""){
            $query = $query->where('restaurant_name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        return view('admin/restaurant/restaurant_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin/restaurant/add_restaurant');
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
            'restaurant_name'=>'required',
            'owner_name'=>'required',
            'latitude'=>'required',
            'owner_name'=>'required',
            'longitude'=>'required', 
            'email'=>'required',  
            'password'=>'required',  
        ]);
        
        
            $model = new Restaurant();
            $model->restaurant_id = "PA00".rand(1000,9999);
            $model->restaurant_name = $request->post('restaurant_name');
            $model->owner_name = $request->post('owner_name');
            $model->mobile = $request->post('mobile');
            $model->email = $request->post('email');
            $model->password = bcrypt($request->password);
            $model->address = $request->post('address');
            $model->latitude = $request->post('latitude');
            $model->longitude = $request->post('longitude');
            $model->created_date = date('Y-m-d');
            $model->status = 1;
            if($request->hasfile('image')){
              $image = $request->file('image');
              $ext = $image->extension();
              $image_name = time().'.'.$ext;
            
              $image->move(public_path('uploads/restaurant_image'), $image_name);
              $model->image = "uploads/restaurant_image/".$image_name;
            }
            $model->save();
            $request->session()->flash('message','Restaurant added successfully.');
            return redirect('sysadmin/restaurant-list');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show($id=""){
            if($id !=""){
                
                 $result['data'] =Restaurant::where('id',$id)->first();
               
                
                
                
                $result['orders_sum'] = Order::where('status',1)->where('restaurant_id',$id)->sum('grand_total');
                $result['orders_count'] = Order::where('status',1)->where('restaurant_id',$id)->count();
                $result['orders'] = Order::where('status',1)->where('order_type','Order')->where('restaurant_id',$id)->orderBy('id','DESC')->get();
                return view('admin/restaurant/edit_restaurant',$result);
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
       $request->validate([
            'restaurant_name'=>'required',
            'owner_name'=>'required',
            'latitude'=>'required',
            'owner_name'=>'required',
            'mobile'=>'required',
            'longitude'=>'required', 
            'hiddenid'=>'required',  
        ]);
        
       
            $model = Restaurant::find($request->hiddenid);
            $model->restaurant_name = $request->post('restaurant_name');
            $model->owner_name = $request->post('owner_name');
            $model->mobile = $request->post('mobile');
            $model->address = $request->post('address');
            $model->email = $request->post('email');
            $model->latitude = $request->post('latitude');
            $model->longitude = $request->post('longitude');
            if($request->hasfile('image')){
              $image = $request->file('image');
              $ext = $image->extension();
              $image_name = time().'.'.$ext;
            
              $image->move(public_path('uploads/restaurant_image'), $image_name);
              $model->image = "uploads/restaurant_image/".$image_name;
            }
            $model->save();
            $request->session()->flash('message','Profile updated successfully.');
            return redirect('sysadmin/edit-restaurant/'.$request->hiddenid);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
    
    
    public function order_index(Request $request)
    {
        $query = Order::where('status',1)->where('order_status','!=','Returned');
        
        if($request->order_number !=""){
            $query = $query->where('order_number','LIKE','%'.$request->order_number.'%');
        }
        if($request->payment_status !=""){
            $query = $query->where('payment_status',$request->payment_status);
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        
        return view('admin/order/order_list',$data);
    }
    
    public function order_show(Order $order,$id="")
    {
        if ($id !='') {
          $data['delivery_boy'] = DeliveryBoy::where('status',1)->orderBy('id','DESC')->get();
            $data['data'] = Order::where(['id'=>$id])->first();
            return view('admin/order/order_details',$data);   
        }
    }
    
     public function update_status(Request $request,$status,$id){

        $arr = array(1,0);
        if($id > 0  AND $id !='' AND in_array($status,$arr)){
    
            $model = Restaurant::find($id);
            $model->status = $status;
            $model->save();
            $request->session()->flash('message','Status updated successfully.');
            return redirect('sysadmin/restaurant-list');
        }else{
            $request->session()->flash('error','Invalid Info.');
            return redirect('sysadmin/restaurant-list');
        }
    }
    
}
