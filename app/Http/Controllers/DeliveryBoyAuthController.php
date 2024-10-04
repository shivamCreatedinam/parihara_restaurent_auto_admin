<?php

namespace App\Http\Controllers;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DeliveryBoyAuthController extends Controller
{
     public function authenticate(Request $request)
    {
      
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|string|min:6|max:20'
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $email = $request->email;
        $password = $request->password;
        
        $check = DeliveryBoy::where('email',$email)->where('status',1)->first();
        if(empty($check)){
             return response()->json([
                     'status' => false,
                     'message' => 'Invalid credentials.',
                 ]);
        }
        if(Hash::check($password,$check->password)){
            
             return response()->json([
                'status' => true,
                'message' => 'successfully logged in.',
                'user'=>$check->name,
                'id'=>$check->id,
            ]);
         }else{
             return response()->json([
                     'status' => false,
                     'message' => 'Invalid credentials.',
                 ]);
         }
        
        
    }
    
    public function my_order_list(Request $request){
        
    
        $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $userid = $request->user_id;
           $result = DB::table('orders')
           ->select('orders.*','ratings.rating','ratings.review')
           ->leftJoin('ratings','ratings.order_number','=','orders.order_number')
           ->where('orders.delivery_boy_id',$userid)
           ->where('orders.status',1)
           ->orderBy('orders.id', 'DESC')->get();
    
           $arr = array('Order Confirmed','Shipped','Out For Delivery');
            foreach ($result as $value) {
                // if(in_array($value->order_status,$arr)){
                //   $value->order_status="Processing";
                // }else{
                 
                // }
                 $value->order_status=$value->order_status;
              $value->product_items = ordered_product_list($value->order_number);
              $value->items_quantity = count(ordered_product_list($value->order_number));
              $data[] = $value;
            }
            if (count($result) > 0) {
              return response()->json([
                          'status' => true,
                          'message' => 'My Order list',
                          'order'=>$data
                   ]);
          
            }else{
                  return response()->json([
                          'status' => false,
                          
                          'message' => 'Order not found',
                   ]);
            }
     
}


    public function my_order_details(Request $request){
            $userid  = Auth::user()->id;
          $validator=Validator::make($request->all(),[
          "order_number"=>'required',
          ]);
     if($validator->fails()){
      return response()->json(['error' => $validator->messages()], 200);
     }else{
      if (user_exist($userid)) {
    
           $result = DB::table('orders')
           ->select('orders.*','ratings.rating','ratings.review','delivery_boys.name as delivery_boy_name','delivery_boys.mobile as delivery_boy_mobile')
           ->leftJoin('ratings','ratings.order_number','=','orders.order_number')
           ->leftJoin('delivery_boys','delivery_boys.id','=','orders.delivery_boy_id')
           ->where('orders.user_id',$userid)->where('orders.order_number',$request->order_number)->first();
    
            $productresult = DB::table('order_products')
            ->select('order_products.*','products.product_name','products.product_code','products.market_price','products.sale_price','products.description','products.id as prodid')
            ->join('products','order_products.product_id','=','products.id')
            ->where('order_products.user_id',$userid)->where('order_products.order_number',$request->order_number)->orderBy('order_products.id', 'DESC')->get();
            $restaurantResult = DB::table('restaurants')->where('id',$result->restaurant_id)->where('status',1)->first();
         foreach ($productresult as $key => $value) {
              $productresult[$key]->image = product_image($value->product_id);
         }
    
      if (!empty($result)) {
          return response()->json([
                      'status' => true,
                      'message' => 'My Order Detals',
                      'items_quantity'=>count($productresult),
                      'order_details'=>$result,
                      'restaurant'=>$restaurantResult,
                       'ordered_product'=>$productresult,
               ]);
      
        }else{
              return response()->json([
                      'status' => false,
                      'message' => 'Order not found',
               ]);
        }
         }else{
             return response()->json([
              'status' => false,
              'message' => 'Invalid User.'
            ]);
           }
      
     }    
    }


    public function cancel_order(Request $request){
        $userid  = Auth::user()->id;
      $validator=Validator::make($request->all(),[
      "order_number"=>'required',
      "remark"=>'required',
      ]);
     if($validator->fails()){
      return response()->json(['error' => $validator->messages()], 200);
     }else{
      if (user_exist($userid)) {
    
      $result = DB::table('orders')->where('user_id',$userid)->where('order_number',$request->order_number)->first();
    
      if (!empty($result)) {
    
        $update = array(
          'order_status'=>'Canceled',
        );
         $updt1 = DB::table('orders')
        ->where('user_id',$userid)
        ->where('order_number',$request->order_number)
        ->update($update);
    
        if($updt1){
            $tran = UserTransaction::insert(
                array(
                    'user_id'=>$userid,
                    'titles'=>'Order No.#'.$request->order_number.' canceled.',
                    'remark'=>'Order No.#'.$request->order_number.' canceled.',
                    'created_date'=>my_date(),
                    'created_time'=>my_time(),
                ));
    
                return response()->json([
                  'status' => true,
                  'message' => 'order canceled.',
                  
              ]);
        }else{
          return response()->json([
            'status' => false,
            'message' => 'order not canceled.',
          ]);
        }
        
    
          
        }else{
              return response()->json([
                      'status' => false,
                      
                      'message' => 'Order not found',
               ]);
        }
         }else{
             return response()->json([
              'status' => false,
              'message' => 'Invalid User.'
            ]);
           }
      
     }    
    }


    public function return_order(Request $request){
     $userid  = Auth::user()->id;       
      $validator=Validator::make($request->all(),[
      "order_number"=>'required',
      "reason_for_return"=>'required',
     
      ]);
     if($validator->fails()){
      return response()->json(['error' => $validator->messages()], 200);
     }
     $pid = sizeof($request->product_id);
     if ($pid == 0) {
      return response()->json([
        'status' => false,
        'message' => 'Select product.',
      ]);
     }
    
      if (user_exist($userid)) {
       
      $result = DB::table('orders')
      ->where('user_id',$userid)
      ->where('order_number',$request->order_number)->first();
    
      if (!empty($result)) {
    
        for ($i=0; $i < $pid; $i++) { 
          $orderedres = DB::table('order_products')
          ->where('user_id',$userid)
          ->where('order_number',$request->order_number)
          ->where('product_id',$request->product_id[$i])
          ->first();
          if (empty($orderedres)) {
              return response()->json([
                'status' => false,
                'message' => 'Product not found.',
              ]); 
          }
        }
        for ($j=0; $j < $pid; $j++) { 
          $updt2 = DB::table('order_products')
          ->where('user_id',$userid)
          ->where('order_number',$request->order_number)
          ->where('product_id',$request->product_id[$j])
          ->update(array(
            'return_status'=>'Return-Request',
            'return_qty'=>$request->qty[$j],
            'return_date'=>my_date(),
            'return_time'=>my_time(),
          ));
        }
    
    
        $update = array(
          'return_reason'=>$request->reason_for_return,
          'return_remark'=>$request->remark,
          'return_date'=>my_date(),
          'return_time'=>my_time(),
        );
    
        $updt1 = DB::table('orders')
        ->where('user_id',$userid)
        ->where('order_number',$request->order_number)
        ->update($update);
    
        if($updt1){
          $tran = UserTransaction::insert(
            array(
                'user_id'=>$userid,
                'titles'=>'Order No.#'.$request->order_number.' is requesting for return.',
                'remark'=>'Order No.#'.$request->order_number.' is requesting for return. Reason - '.$request->reason_for_return.' Remark - '.$request->remark,
                'created_date'=>my_date(),
                'created_time'=>my_time(),
            ));
    
              return response()->json([
                  'status' => true,
                  'message' => 'Return requested successfully.', 
              ]);
        }else{
          return response()->json([
            'status' => false,
            'message' => 'Something wrong.',
          ]);
        }
        
    
          
        }else{
              return response()->json([
                      'status' => false,
                      'message' => 'Order not found',
               ]);
        }
         }else{
             return response()->json([
              'status' => false,
              'message' => 'Invalid User.'
            ]);
           }
      
       
    }
}
