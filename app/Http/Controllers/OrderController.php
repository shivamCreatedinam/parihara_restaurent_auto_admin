<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\UserTransaction;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        
        return view('restaurant/order/order_list',$data);
    }
    public function return_orders(Request $request)
    {
        $query = Order::where('status',1)->where('order_status','Returned');
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
        return view('restaurant/order/return_order_list',$data);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_order_status(Request $request)
    {
        $request->validate([
            'orderid'=>'required',
            'order_number'=>'required',
            'order_status'=>'required',
        ]);
        
        if($request->post('orderid') > 0 ){
            if ($request->post('order_status') == 'Returned') {
                $request->session()->flash('erorr','You can`t Return order.');
                return redirect('restaurant/view-order-details/'.$request->post('orderid'));
            }
        
        $msg = "Order Status ".$request->post('order_status')."   successfully.";
        $res = Order::where('id',$request->post('orderid'))->where('order_number',$request->post('order_number'))->first();

        $model = Order::find($request->post('orderid'));
        $model->order_status = $request->post('order_status');
        
        if ($request->post('order_status') =='Canceled') {
            $model->cancel_date = date('Y-m-d H:i:s');
            $model->cancel_remark = $request->cancel_remark;
        }
        if ($request->post('order_status') =='Out For Delivery') {
          $model->delivery_boy_id = $request->delivery_boy;
        }
        if ($request->post('order_status') =='Delivered') {
             $model->payment_status = "Success";
            $model->delivered_date = date('Y-m-d H:i:s');
        }
        if ($model->save()) {
            $tran = UserTransaction::insert(
                array(
                    'user_id'=> $res->user_id,
                    'titles'=>'Order No.#'.$request->post('order_number').' is '.$request->post('order_status'),
                    'remark'=>'Order No.#'.$request->post('order_number').' is '.$request->post('order_status'),
                    'created_date'=>my_date(),
                    'created_time'=>my_time(),
                ));
                
                 $userData = DB::table('users')->select('firbase_token')->where('id',$res->user_id)->where('status',1)->first();
                    if(!empty($userData)){
                        $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
                        define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                         if($userData->firbase_token !=''){
                             
                         
                                    $fcmMsg = array(
                                        'title' =>  'Dear User ! Order No.#'.$request->post('order_number').' has been '.$request->post('order_status'),
                                        'body' =>'Dear User ! Order No.#'.$request->post('order_number').' has been '.$request->post('order_status'),
                                        'sound' => 'noti_sound1.wav',
                                        'android_channel_id' => 'restaurent_channel',
                                      );
                                      $fcmFields = array(
                                        'to' => $userData->firbase_token, //tokens sending for notification
                                        'notification' => $fcmMsg,
                                        'data'=>$model,
                                         'send_type'=>"accept_user_ride",
                                        'notification_type'=>'User',
                                        'content_available' => true,
                                        'priority' => 'high',
                                    
                                      );
                                    
                                      $headers = array(
                                        'Authorization: key=' . API_ACCESS_KEY,
                                        'Content-Type: application/json'
                                      );
                                    
                                    $ch = curl_init();
                                    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                                    curl_setopt( $ch,CURLOPT_POST, true );
                                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
                                    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
                                    $result = curl_exec($ch );
                                    curl_close( $ch );
                                    // echo $result . "\n\n";
                            } 
                          
                    }

            $sts = DB::table('order_status')->where('order_status',$request->post('order_status'))->first();
                if (!empty($sts)) {
                    $insert_status = DB::table('ordered_status')->insert(array(
                        'user_id'=>$res->user_id,
                        'order_number'=>$request->post('order_number'),
                        'order_sort'=>$sts->order_sort,
                        'order_status'=>$sts->order_status,
                        'created_date'=>my_date(),
                        'created_time'=>my_time()
                    )); 
                }  
               
                $request->session()->flash('message',$msg);
          
            return redirect('restaurant/view-order-details/'.$request->post('orderid'));
        }else{
            
            $request->session()->flash('erorr','Something wrong!');
            return redirect('restaurant/view-order-details/'.$request->post('orderid'));  
        }
        
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order,$id="")
    {
        if ($id !='') {
          $data['delivery_boy'] = DeliveryBoy::where('status',1)->orderBy('id','DESC')->get();
            $data['data'] = Order::where(['id'=>$id])->first();
            return view('restaurant/order/order_details',$data);   
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
