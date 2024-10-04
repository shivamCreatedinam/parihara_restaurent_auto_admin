<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\ContactQuery;
use App\Models\Rating;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Slot;
use App\Models\Order;
use App\Models\Faq;
use App\Models\TermsAndCondition;
use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\PrivacyPolicy;
use App\Models\Location;
use App\Models\Estimated_delivery;
use App\Models\ProdSelctdAttri;

use Illuminate\Support\Facades\Validator;

class AppHome extends Controller
{
    public function homepage(Request $request){
        $slider = Slider::where('status','1')->where('slider_type','Slider')->orderBy('id','DESC')->get();
        $banner = Slider::where('status','1')->where('slider_type','Banner')->orderBy('id','DESC')->get();
        $popular = Product::where('status','1')->where('popular','1')->orderBy('id','DESC')->get();
        $dealResult = Product::where('status','1')->where('deals_of_week','1')->orderBy('id','DESC')->get();
        $restaurantResult = DB::table('restaurants')->where('status',1)->get();
        $alldata = [];
        
        foreach($popular as $key => $value){
            
                $value->image = product_image($value->id);
                $att =  product_selected_attris($value->id);
                $value->attributes_id = $att->attributes_id;
                $value->market_price = $att->mrp;
                $value->discount = $att->discount;
                $value->sale_price = $att->saling_price;
                $value->attribute_title = $att->attribute_title;
                $value->qty = $att->qty;
                
                $alldata[] = $value;
        }
        
        $dealdata = [];
        foreach($dealResult as $key => $value){
            
                $value->image = product_image($value->id);
                $att =  product_selected_attris($value->id);
                $value->attributes_id = $att->attributes_id;
                $value->market_price = $att->mrp;
                $value->discount = $att->discount;
                $value->sale_price = $att->saling_price;
                $value->attribute_title = $att->attribute_title;
                $value->qty = $att->qty;
                
                $dealdata[] = $value;
        }
        
          return response()->json([
                'status' => true,
                'message' => 'Home data',
                'slider'=>$slider,
                'featured'=>$banner,
                'popular'=>$alldata,
                'deals_of_week'=>$dealdata,
                'restaurant'=>$restaurantResult,
            ]);
    }
    
    
     public function restaurant_product_list(Request $request){
        $userid  = Auth::user()->id;
        $data = $request->only('restaurant_id');
          $validator = Validator::make($data, [
            'restaurant_id' => 'required',
            ]);
         if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            
            $restaurantResult = DB::table('restaurants')->where('id',$request->restaurant_id)->where('status',1)->first();
              
              if(empty($restaurantResult)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid restaurant.',  
                ]);
              }
              
          $product = Product::select('id','category_id',
          'product_name','product_code','description')
          ->where('status','1')
          ->where('restaurant_id',$request->restaurant_id)
          ->orderBy('id','DESC')->get();
            if (count($product) > 0) {
                foreach ($product as $value) {

                  $value->image = product_image($value->id);
                  $att =  product_selected_attris($value->id);

                  $value->attributes_id = $att->attributes_id;
                  $value->market_price = $att->mrp;
                  $value->discount = $att->discount;
                  $value->sale_price = $att->saling_price;
                  $value->attribute_title = $att->attribute_title;
                    $value->qty = $att->qty;
                    
                  $checkwishlist=DB::table('favorites')
                  ->where(['user_id'=>$userid])
                  ->where(['product_id'=>$value->id])
                  ->count();

                 

                  if ($checkwishlist > 0) {
                    $wishstatus = "Yes";
                  }else{
                    $wishstatus = "No";
                  }

                 

                  $checkcart=DB::table('cart')
                  ->where(['user_id'=>$userid])
                  ->where(['product_id'=>$value->id])
                  ->first();

                  if (!empty($checkcart)) {
                    $cartstatus = "Yes";
                  $cartqty =   $checkcart->qty;
                  }else{
                    $cartstatus = "No";
                    $cartqty=0;
                  }
                  $value->cart_qty = $cartqty;
                  $value->cart_status = $cartstatus;
                  $value->wishlist_status = $wishstatus;
                  $alldata[] = $value;
                }
                 return response()->json([
                    'status' => true,
                    'message' => 'Restaurant Product List',
                    'product'=>$alldata,
                     
                ]);
           }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.',  
                ]);
             }   
               
    } 
    
     public function set_price(Request $request){
         $data = DB::table('set_prices')->where('id','1')->where('status','1')->first();
       
        if(!empty($data)){
          return response()->json([
                'status' => true,
                'message' => 'price data',
                'data'=>$data,
            ]);  
        }else{
            return response()->json([
                'status' => false,
                'message' => 'data not found.',
                
            ]);
        }
          
    }
   

    public function category_list(Request $request){
           
            
        $category = Category::where('status','1')->orderBy('id','DESC')->get();

        if (count($category) > 0) {
          
            return response()->json([
                'status' => true,
                'message' => 'category list',
                'category'=>$category,
            ]);
        }else{
          return response()->json([
                'status' => false,
                'message' => 'data not found',
            ]);
        }   
    }

    public function category_product_list(Request $request){
        $userid  = Auth::user()->id;
        $data = $request->only('category_id');
          $validator = Validator::make($data, [
            'category_id' => 'required',
            ]);
         if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
              
          $product = Product::select('id','category_id',
          'product_name','product_code','description')
          ->where('status','1')
          ->where('category_id',$request->category_id)
          ->orderBy('id','DESC')->get();
            if (count($product) > 0) {
                foreach ($product as $value) {

                  $value->image = product_image($value->id);
                  $att =  product_selected_attris($value->id);

                  $value->attributes_id = $att->attributes_id;
                  $value->market_price = $att->mrp;
                  $value->discount = $att->discount;
                  $value->sale_price = $att->saling_price;
                  $value->attribute_title = $att->attribute_title;
                    $value->qty = $att->qty;
                    
                  $checkwishlist=DB::table('favorites')
                  ->where(['user_id'=>$userid])
                  ->where(['product_id'=>$value->id])
                  ->count();

                 

                  if ($checkwishlist > 0) {
                    $wishstatus = "Yes";
                  }else{
                    $wishstatus = "No";
                  }

                 

                  $checkcart=DB::table('cart')
                  ->where(['user_id'=>$userid])
                  ->where(['product_id'=>$value->id])
                  ->first();

                  if (!empty($checkcart)) {
                    $cartstatus = "Yes";
                  $cartqty =   $checkcart->qty;
                  }else{
                    $cartstatus = "No";
                    $cartqty=0;
                  }
                  $value->cart_qty = $cartqty;
                  $value->cart_status = $cartstatus;
                  $value->wishlist_status = $wishstatus;
                  $alldata[] = $value;
                }
                 return response()->json([
                    'status' => true,
                    'message' => 'Category Product List',
                    'product'=>$alldata,
                     
                ]);
           }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.',  
                ]);
             }   
               
    } 

    public function product_details(Request $request){
        $userid  = Auth::user()->id;
        $data = $request->only('product_id');
        $validator = Validator::make($data, [
        'product_id' => 'required',
            ]);
          if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            
              $product = Product::select('products.*','product_attributes.attribute_title','categories.category_name')
              ->leftJoin('product_attributes','product_attributes.id','=','products.attribute_id')
              ->leftJoin('categories','categories.id','=','products.category_id')
              ->where('products.status','1')->where('products.id',$request->product_id)
              ->first();
              $product->image = product_image($product->id);

              
             
              $productatt = ProdSelctdAttri::select('prod_selctd_attris.*','product_attributes.attribute_title')
              ->leftJoin('product_attributes','product_attributes.id','=','prod_selctd_attris.attributes_id')
              ->where('prod_selctd_attris.product_id',$product->id)
              ->get();

          if (!empty($product)) {
               
             $checkwishlist=DB::table('favorites')
              ->where(['user_id'=>$userid])
              ->where(['product_id'=>$product->id])
              ->count();
              if ($checkwishlist > 0) {
                $wishstatus = "Yes";
              }else{
                $wishstatus = "No";
              }

              $checkcart=DB::table('cart')
                  ->where(['user_id'=>$userid])
                  ->where(['product_id'=>$product->id])
                  ->first();

                  if (!empty($checkcart)) {
                    $cartstatus = "Yes";
                  $cartqty =   $checkcart->qty;
                  }else{
                    $cartstatus = "No";
                    $cartqty=0;
                  }
                  $product->cart_qty = $cartqty;
                  $product->cart_status = $cartstatus;

              $product->wishstatus =  $wishstatus;

             return response()->json([
              'status' => true,
              'message' => 'Product Details',
              'product_details'=>$product,
              'prod_attributes'=>$productatt,
            //   'product_favourite_status'=>$wishstatus,
              
             ]);
          }else{
             return response()->json([
              'status' => false,
              'message' => 'Data not found',
             ]);
          }
    } 


    public function add_to_favourite(Request $request){
        $userid  = Auth::user()->id;
        $data = $request->only('product_id');
        $validator = Validator::make($data, [
        'product_id' => 'required',
            ]);
          if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }

            $check = DB::table('favorites')->where(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id])->count();
            
                if ($check > 0) {
                   return response()->json([
              
                'status' => false,
                'message' => 'Already added in your favourite list',
                 ]);
                }else{
                    DB::table('favorites')->insert(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id]);
                    
                return response()->json([
                        'status' => true,
                        'message' => 'Added in your favourite list',
                 ]);
                }
              
    
    }

    public function remove_favourite(Request $request){
        $userid  = Auth::user()->id;
        $data = $request->only('product_id','user_id');
        $validator = Validator::make($data, [
       'product_id' => 'required',
        'user_id'=> 'required',
            ]);
          if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }

            $check = DB::table('favorites')->where(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id])->count();
            
              if ($check > 0) {
                DB::table('favorites')->where(['user_id'=>$userid,'product_id'=>$request->product_id])->delete();
                   
                return response()->json([
                'status' => true,
                'message' => 'Removed from favourite list',
                 ]);
                }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'Invalid id',
                     ]);
                }
    }


    public function my_favourite_list(Request $request){
        $userid  = Auth::user()->id;
        
          $check = DB::table('favorites')
          ->select('products.id','products.category_id',
          'products.product_name','products.product_code','products.description','favorites.id as favoritesid')
          ->join('products','favorites.product_id','=','products.id')
          ->where('products.status','1')
          ->where(['favorites.user_id'=>$userid,'favorites.user_type'=>"Reg",'products.status'=>1])->get();
          
          
             

            if (count($check) > 0) {

              foreach ($check as $value) {
                $value->image = product_image($value->id);
                $att =  product_selected_attris($value->id);

                $value->attributes_id = $att->attributes_id;
                $value->market_price = $att->mrp;
                $value->discount = $att->discount;
                $value->sale_price = $att->saling_price;
                $value->attribute_title = $att->attribute_title;
                 $value->qty = $att->qty;
                 
                $checkcart=DB::table('cart')
                ->where(['user_id'=>$userid])
                ->where(['product_id'=>$value->id])
                ->first();

                if (!empty($checkcart)) {
                  $cartstatus = "Yes";
                $cartqty =   $checkcart->qty;
                }else{
                  $cartstatus = "No";
                  $cartqty=0;
                }
                $value->cart_qty = $cartqty;
                $value->cart_status = $cartstatus;

                $datasss[] = $value;
              }

              return response()->json([
              'status' => true,
              'message' => 'My favourite list',
              'favourite'=>$datasss
               ]);
              }else{
                 return response()->json([
                  'status' => false,
                  'message' => 'data not found',
                   ]);
              }
        }

        public function add_to_cart(Request $request){
        $userid  = Auth::user()->id;
          $validator = Validator::make($request->all(), [
          'product_id' => 'required',
          'attribute_id' => 'required',
          'qty' => 'required|numeric',
              ]);
            if ($validator->fails()) {
                  return response()->json(['error' => $validator->messages()], 200);
              }
               if (user_exist($userid)) {
                 $check = DB::table('cart')->where(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id])->count();
              
                  if ($check > 0) {
                     return response()->json([
                      'status' => false,
                      'message' => 'Already added in your cart list',
                       ]);
                  }else{
                    $product = DB::table('products')->where(['id'=>$request->product_id])->first();
                    $productatt = DB::table('prod_selctd_attris')
                    ->select('prod_selctd_attris.*','product_attributes.attribute_title')
                    ->leftJoin('product_attributes','product_attributes.id','=','prod_selctd_attris.attributes_id')
                    ->where(['product_id'=>$request->product_id])
                    ->where(['attributes_id'=>$request->attribute_id])
                    ->first();
                    if (empty($product)) {
                      return response()->json([
                        'status' => false,
                        'message' => 'Product not exists.',
                    ]);
                    }

                    if (empty($productatt)) {
                      return response()->json([
                        'status' => false,
                        'message' => 'Product attribute not exists.',
                    ]);
                    }
                    $totalprice = $productatt->saling_price * $request->qty;

                      DB::table('cart')->insert(['user_id'=>$userid,'user_type'=>"Reg",'restaurant_id'=>$product->restaurant_id,'product_id'=>$request->product_id,'attribute_id'=>$request->attribute_id,'attribute_title'=>$productatt->attribute_title,'qty'=>$request->qty,'price'=>$productatt->saling_price,'total_price'=>$totalprice]);
                      
                  return response()->json([
                          'status' => true,
                          'message' => 'Added in your cart list',
                   ]);
                  }
               }else{
                 return response()->json([
                  'status' => false,
                  'message' => 'Invalid User.'
                ]);
               }
      }

      public function remove_from_cart(Request $request){
        $userid  = Auth::user()->id;   
        $validator = Validator::make($request->all(), [
       'product_id' => 'required',
        
            ]);
          if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }

            if (user_exist($userid)) {
               $check = DB::table('cart')->where(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id])->count();
            
                if ($check > 0) {
                  DB::table('cart')->where(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id])->delete();
                   
                    return response()->json([
                    'status' => true,
                    'message' => 'Removed from cart list',
                     ]);
                   
                }else{
                  
                return response()->json([
                        'status' => false,
                        'message' => 'Invalid id.',
                 ]);
                }
             }else{
               return response()->json([
                'status' => false,
                'message' => 'Invalid User.'
              ]);
             }
    }

    public function my_cart_list(Request $request){
            
    $userid  = Auth::user()->id;
           if (user_exist($userid)) {
             $result = DB::table('cart')
             ->select('products.id','products.category_id',
             'products.product_name','products.product_code','products.description','cart.id as cartid','cart.qty as cart_qty',
             'cart.attribute_id','cart.attribute_title','cart.price','cart.total_price')
             ->join('products','cart.product_id','=','products.id')
             ->where(['cart.user_id'=>$userid,'cart.user_type'=>"Reg",'products.status'=>1])->get();

                $total=DB::table('cart')
                ->where(['user_id'=>$userid])
                ->where(['user_type'=>"Reg"])
                ->sum('total_price');
          
              if (count($result) > 0) {

                foreach ($result as $value) {
                  $value->image = product_image($value->id);
                  $value->cart_qty = (int)$value->cart_qty;
                  $data[] = $value;
                }

                $deliverycharge = DB::table('delivery_charges')->first();
                 if(!empty($deliverycharge)){
                     
                 $deliverychargeS = $deliverycharge->delivery_charge;
                 }else{
                     $deliverychargeS =0;
                 }
                 
                 return response()->json([
                  'status' => true,
                  'message' => 'Cart list',
                  'total_price'=>$total+$deliverychargeS,
                  'cart_count'=>count($result),
                  'delivery_charge'=>$deliverychargeS,
                  'cart'=>$data
                   ]);
              }else{
                
                  
              return response()->json([
                      'status' => false,
                      'message' => 'Empty cart',
               ]);
              }
           }else{
             return response()->json([
              'status' => false,
              'message' => 'Invalid User.'
            ]);
           }
  }


  public function slot_list(Request $request){
        
           $result = Slot::where('status',1)->orderBy('id','ASC')->get();
        
            if (count($result) > 0) {

               return response()->json([
                'status' => true,
                'message' => 'Slots list',
                'slots'=>$result,
                 ]);

            }else{  

            return response()->json([
                    'status' => false,
                    'message' => 'Empty cart',
             ]);

            }    
    }


    public function cart_update(Request $request){
            $userid  = Auth::user()->id;
      $validator = Validator::make($request->all(), [
      'product_id' => 'required',
      'qty' => 'required|numeric',
          ]);
        if ($validator->fails()) {
              return response()->json(['error' => $validator->messages()], 200);
          }
           if (user_exist($userid)) {
             $check = DB::table('cart')->where(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id])->first();
          
              if (!empty($check)) {
                $product = DB::table('products')->where(['id'=>$request->product_id])->first();

                if (empty($product)) {
                  return response()->json([
                    'status' => false,
                    'message' => 'Invalid product id.',
                     ]);
                }
                $totalprice = $check->price * $request->qty;

                DB::table('cart')->where(['user_id'=>$userid,'user_type'=>"Reg",'product_id'=>$request->product_id])->update(array('qty'=>$request->qty,'total_price'=>$totalprice));
                  
              return response()->json([
                      'status' => true,
                      'message' => 'Cart updated successfully.',
               ]);

               
              }else{
                 return response()->json([
                  'status' => false,
                  'message' => 'Item not found.',
                   ]);
              }
           }else{
             return response()->json([
              'status' => false,
              'message' => 'Invalid User.'
            ]);
           }
   }



   public function apply_promocode(Request $request){
    
    $userid = Auth::user()->id;
    
    $validator = Validator::make($request->all(), [
    'promocode' => 'required',
    'amount' => 'required',
        ]);
      if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
         if (user_exist($userid)) {
          
          $promocode =  check_promocode($request->promocode);

        
        //   $total=DB::table('cart')
        //       ->where(['user_id'=>$userid])
        //       ->where(['user_type'=>"Reg"])
        //       ->sum('total_price');

        //       $cartcount =  DB::table('cart')->where(['user_id'=>$userid,'user_type'=>'Reg'])->count();

        //       if ($cartcount <= 0) {
        //           return response()->json([
        //                       'status' => false,
        //                       'message' => 'Empty cart.',
        //               ]);
        //       }
        
        $total = $request->amount;

          if (!empty($promocode)) {
            if (date('Y-m-d H:i:s') >= date('Y-m-d H:i:s',strtotime($promocode->valid_from))  && date('Y-m-d H:i:s') <= date('Y-m-d H:i:s',strtotime($promocode->expires_on))) {
              if ($promocode->user_type == 'Selected-User') {
                  $selectcount = DB::table('coupon_selected_users')
                  ->where('user_id',$userid)
                  ->where('coupon_id',$promocode->id)
                  ->get();
                  if(count($selectcount) == 0){
                    return response()->json([
                      'status' => false,
                      'message' => 'Sorry,this coupon code is not applicable for you.',
                      ]);
                  }
                
                }

                if ($promocode->discount_type == 'Fixed') {

                  $discounted = $total - (int)$promocode->discount;
                  
                  $discountedval = (int)$promocode->discount;
                }
                if ($promocode->discount_type == 'Percentage') {
                
                  $discountedval = ($total * (int)$promocode->discount/100);
                  $discounted = $total -  $discountedval;
                }

               
                return response()->json([
                    'status' => true,
                    'cartamount'=>"$total",
                    'discounted_value'=>"$discountedval",
                    'after_discounted_cart_amount'=>"$discounted",
                    'message' => 'Coupon code applied successfully.',
                  ]);
              
                if ($total < $discounted) {
                 return response()->json([
                              'status' => false,
                              'message' => 'You are not able to use this promocode,you have less amount in your cart subtotal.',
                       ]);
                }

            }else{
              return response()->json([
                    'status' => false,
                    'message' => 'Invalid promocode.',
             ]);

            }

          }else{
             return response()->json([
                    'status' => false,
                    'message' => 'Invalid promocode.',
             ]);

          }

          
         }else{
           return response()->json([
            'status' => false,
            'message' => 'Invalid User.'
          ]);
         }
}




   public function place_order(Request $request){
        $userid  = Auth::user()->id;
        $validator=Validator::make($request->all(),[
        "user_id"=>'required',
        "payment_mode"=>'required',
        "address_id"=>'required',
        'delivery_charge'=>'required'
        ]);
   if($validator->fails()){
    return response()->json(['error' => $validator->messages()], 200);
   }else{
    if (user_exist($userid)) {
         $payment_type = $request->payment_mode;
        if($payment_type == 'COD'){
            $ordrsts = 1;
            $orderstatus = "Processing";
        }
         if($payment_type == 'ONLINE'){
            $ordrsts = 0;
             $orderstatus = "Pending";
        }
      $total=DB::table('cart')
              ->where(['user_id'=>$userid])
              ->where(['user_type'=>"Reg"])
              ->sum('total_price');

      $cartcount =  DB::table('cart')->where(['user_id'=>$userid,'user_type'=>'Reg'])->get();

              if (count($cartcount) <= 0) {
                  return response()->json([
                              'status' => false,
                              'message' => 'Empty cart.',
                       ]);
              }
              
              if(count($cartcount) > 0){
                  $restaurantid = $cartcount[0]->restaurant_id;
              }else{
                  $restaurantid = "";
              }
              
      if ($request->promocode != '') {
        
         $couponresponse = $this->apply_promocode($request);
       
        $CopnRes = json_encode($couponresponse);
         $CopnResDec = json_decode($CopnRes);
        
        if ($CopnResDec->original->status==false) {
          return $couponresponse;
        }else{
          $grandtotal = $CopnResDec->original->after_discounted_cart_amount +$request->delivery_charge;
          $discountvalue = $CopnResDec->original->discounted_value;
          $applied_coupon_code = $request->promocode;
        }
        
        }else{
          $grandtotal = $total + $request->delivery_charge;
          $discountvalue = "0";
          $applied_coupon_code="";

        }


         $last2 = DB::table('orders')->orderBy('id', 'DESC')->first();
        if (!empty($last2)) {
            $lst = $last2->id+1;
        }else{
            $lst = 1;
        }
       $ordernumber = "PARI00".$lst;
       $uid = $userid;
    
   
     

     $address = DB::table('address_books')->where('id',$request->address_id)->first();     
      if (empty($address)) {
              return response()->json([
                    'status' => false,
                    'message' => 'Select address',
             ]);
            }  

    $arr=array(
        "user_id"=>$uid,
        "order_type"=>"Order",
        "address_id"=>$request->address_id,
        "restaurant_id"=>$restaurantid,
        "order_number"=>$ordernumber,
        "applied_coupon_code"=>$applied_coupon_code,
        "discount_value"=>$discountvalue,
        "discount_amount"=>$discountvalue,
        "delvery_charge"=>$request->delivery_charge,
        "sub_total"=>$total,
        "grand_total"=>$grandtotal,
        "slot_id"=>'1',
        "selected_slot"=>'11',
        "address_id"=>$address->id,
        "full_name"=>$address->full_name,
        "mobile"=>$address->mobile,
        "house_no"=>$address->house_no,
        "appartment"=>$address->appartment,
        "state"=>$address->state,
        "city"=>$address->city,
        "pincode"=>$address->pincode,
        "address_type"=>$address->address_type,
        "latitude"=>$address->latitude,
        "longitude"=>$address->longitude,
        "payment_mode"=>$payment_type,
        "payment_status"=>'Pending',
        "order_status"=>$orderstatus,
      
        "status"=>$ordrsts,
        "created_date"=>my_date(),
        "created_time"=>my_time()
    );
    
    $order_id=DB::table('orders')->insertGetId($arr);    
    if ($order_id > 0) {

        $cartquery=DB::table('cart')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>'Reg'])
        ->get();
         $check = count($cartquery);
        

        if ($check > 0) {
            foreach($cartquery as $list){
              
                $prductDetailArr['user_id']=$uid;
                $prductDetailArr['order_id']=$order_id;
                $prductDetailArr['order_number']=$ordernumber;
                $prductDetailArr['product_id']=$list->product_id;
                $prductDetailArr['attribute_id']=$list->attribute_id;
                $prductDetailArr['attribute_title']=$list->attribute_title;
                $prductDetailArr['qty']=$list->qty;
                $prductDetailArr['price']=$list->price;
                $prductDetailArr['total_price']=$list->total_price;
                DB::table('order_products')->insert($prductDetailArr);

                $prodres=DB::table('products')
                ->where(['id'=>$list->product_id])
                ->first();

                $minus = $prodres->qty - $list->qty;
  
                $updataprod = array('qty'=>$minus);
               
                $prodres=DB::table('products')
                ->where(['id'=>$list->product_id])
                ->update($updataprod);
            }  
        }
        
        if($payment_type == 'COD'){
                
                $tran = UserTransaction::insert(
              array(
                  'user_id'=>$userid,
                  'titles'=>'Order No.#'.$ordernumber.' placed successfully.',
                  'remark'=>'Order No.#'.$ordernumber.' placed successfully , your order in processing.',
                  'created_date'=>my_date(),
                  'created_time'=>my_time(),
              ));
            $insert_status = DB::table('ordered_status')->insert(array(
              'user_id'=>$userid,
              'order_number'=>$ordernumber,
              'order_sort'=>'1',
              'order_status'=>'Processing',
              'created_date'=>my_date(),
              'created_time'=>my_time()
            ));
                
        }
        
        

        DB::table('cart')->where([
        'user_id'=>$uid,
        'user_type'=>'Reg'])->delete();
              
             return response()->json([
                  'status' => true,
                  'message' => 'Order has been Successfully Placed, Order Number is '.$ordernumber,
                  'order_number'=>$ordernumber,
                  'payment_type'=>$payment_type
                 
             ]);

        
      }else{
            return response()->json([
                    'status' => false,
                    'message' => 'Order not placed',
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

public function order_status_list(Request $request){
    $userid  = Auth::user()->id;
  $validator=Validator::make($request->all(),[
  "user_id"=>'required',
  "order_number"=>'required',
  ]);
  
 if($validator->fails()){
  return response()->json(['error' => $validator->messages()], 200);
 }else{
  if (user_exist($userid)) {

    //   $result = DB::table('ordered_status')
    //   ->where('user_id',$request->user_id)->where('order_number',$request->order_number)->groupBy('order_status')->orderBy('order_sort', 'ASC')->get();
       
        $result = DB::table('ordered_status')->where('user_id',$userid)->where('order_number',$request->order_number)->orderBy('order_sort', 'ASC')->get()->groupBy(function($data) {
            return $data->order_status;
        });
        
    if (count($result) > 0) {
        return response()->json([
                    'status' => true,
                    'message' => ' Order status list',
                    'order'=>$result
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


public function my_order_list(Request $request){
        $userid  = Auth::user()->id;
    
         if (user_exist($userid)) {

           $result = DB::table('orders')
           ->select('orders.*','ratings.rating','ratings.review')
           ->leftJoin('ratings','ratings.order_number','=','orders.order_number')
           ->where('orders.user_id',$userid)->orderBy('orders.id', 'DESC')->get();
    
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
    }else{
         return response()->json([
          'status' => false,
          'message' => 'Invalid User.'
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


public function coupon_list(Request $request){
        
  $result = DB::table('coupons')->where('status',1)->orderBy('id', 'DESC')->get();
        
      if (count($result) > 0) {
        $data = array();
        foreach ($result as $value) {
          // if (my_date() >= $value->valid_from AND my_date() <= $value->expires_on) {
             $data[] = $value;
          // }
          
        }

        if (count($data) > 0) {
          return response()->json([
            'status' => true,
            'message' => 'Coupon code list',
            'coupons'=>$data
        ]);
        }else{
          return response()->json([
            'status' => false,
            'message' => 'Coupon code not found',
          ]);
        }

          
      
        }else{
              return response()->json([
                      'status' => false,
                      'message' => 'Coupon code not found',
               ]);
        }
}


public function search_product_list(Request $request){
$userid  = Auth::user()->id;
  $data = $request->only('keywords');
    $validator = Validator::make($data, [
      'keywords' => 'required',
      ]);
   if ($validator->fails()) {
          return response()->json(['error' => $validator->messages()], 200);
      }
        
    $product = Product::select('id','category_id',
    'product_name','product_code','description')
    ->where('status','1')
    ->where('product_name','like',  '%' .$request->keywords.'%')
        ->orderBy('id','DESC')->get();
      if (count($product) > 0) {
          foreach ($product as $value) {

              $value->image = product_image($value->id);

              $att =  product_selected_attris($value->id);

              $value->attributes_id = $att->attributes_id;
              $value->market_price = $att->mrp;
              $value->discount = $att->discount;
              $value->sale_price = $att->saling_price;
              $value->attribute_title = $att->attribute_title;
            $value->qty = $att->qty;
              
             $checkwishlist=DB::table('favorites')
            ->where(['user_id'=>$userid])
            ->where(['product_id'=>$value->id])
            ->count();


            if ($checkwishlist > 0) {
              $wishstatus = "Yes";
            }else{
              $wishstatus = "No";
            }


            $checkcart=DB::table('cart')
                  ->where(['user_id'=>$userid])
                  ->where(['product_id'=>$value->id])
                  ->first();

                  if (!empty($checkcart)) {
                    $cartstatus = "Yes";
                  $cartqty =   $checkcart->qty;
                  }else{
                    $cartstatus = "No";
                    $cartqty=0;
                  }
                  $value->cart_qty = $cartqty;
                  $value->cart_status = $cartstatus;


            $value->wishlist_status = $wishstatus;
            $alldata[] = $value;
          }
           return response()->json([
              'status' => true,
              'message' => 'Product List',
              'product'=>$alldata,
               
          ]);
     }else{
          return response()->json([
              'status' => false,
              'message' => 'Data not found.',  
          ]);
       }            
  } 

  public function faq_list(Request $request){

    
      $faq = Faq::where('status','1')
        ->orderBy('id','ASC')->get();
        if (count($faq) > 0) {
           
             return response()->json([
                'status' => true,
                'message' => 'Faq List',
                'faq'=>$faq,
                 
            ]);
       }else{
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',  
            ]);
         }   
           
    } 

    public function terms_and_condition_list(Request $request){

      $terms = TermsAndCondition::where('status','1')
        ->orderBy('id','ASC')->get();
        if (count($terms) > 0) {
           
             return response()->json([
                'status' => true,
                'message' => 'Terms & Conditions',
                'terms'=>$terms,
                 
            ]);
       }else{
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',  
            ]);
         }   
           
    } 


    public function privacy_policy_list(Request $request){
      
      $privacy_policy = PrivacyPolicy::where('status','1')
        ->orderBy('id','ASC')->get();
        if (count($privacy_policy) > 0) {
           
             return response()->json([
                'status' => true,
                'message' => 'Privacy Policy',
                'privacy_policy'=>$privacy_policy,
                 
            ]);
       }else{
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',  
            ]);
         }   
           
    } 

    public function about_us_list(Request $request){
      
      $about_us = AboutUs::where('status','1')
        ->orderBy('id','ASC')->get();
        if (count($about_us) > 0) {
           
             return response()->json([
                'status' => true,
                'message' => 'About us',
                'about_us'=>$about_us,
                 
            ]);
       }else{
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',  
            ]);
         }   
           
    } 

    public function contact_us_list(Request $request){
      
      $contact_us = ContactUs::where('status','1')
        ->orderBy('id','ASC')->get();
        if (count($contact_us) > 0) {
           
             return response()->json([
                'status' => true,
                'message' => 'Contact us',
                'contact_us'=>$contact_us,
                 
            ]);
       }else{
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',  
            ]);
         }   
           
    } 

    public function check_location_list(Request $request){

      $data = $request->only('pincode');
        $validator = Validator::make($data, [
          'pincode' => 'required|min:6|max:6',
          ]);
       if ($validator->fails()) {
              return response()->json(['error' => $validator->messages()], 200);
          }
            
        $location = Location::where('pincode',$request->pincode)->where('status','1')->count();
          if ($location > 0) {
              
               return response()->json([
                  'status' => true,
                  'message' => 'Service provided',
              ]);
          }else{
              return response()->json([
                  'status' => false,
                  'message' => 'Sorry ! we are unable to provide the service in your location, we will started soon.',  
              ]);
           }            
      }


      public function estimated_delivery_days_list(Request $request){

       
              
          $result = Estimated_delivery::where('status','1')->orderBy('id','DESC')->get();
            if (count($result) > 0) {
                
                 return response()->json([
                    'status' => true,
                    'message' => 'Estimated days list',
                    'data' => $result,
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'data not found.',  
                ]);
             }            
        }

      public function general_permissions(Request $request){
      
        $general_setting = DB::table('general_settings')
        ->where('id','1')
        ->first();
        $cancel_order_status = DB::table('order_cancel_permission')
        ->where('id','1')
        ->first();
        return response()->json([
          'status' => true,
          'message' => 'General Settings',
          'general_setting'=>$general_setting,
          'cancel_order_status'=>$cancel_order_status,
           
      ]);
             
      } 


      public function submit_contact_us_query(Request $request){

       
          $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'queries' => 'required',
            'user_id' => 'required',
            ]);
         if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
              
          $model = new ContactQuery();
          $model->name =$request->name;
          $model->email =$request->email;
          $model->mobile =$request->mobile;
          $model->queries =$request->queries;
          $model->user_id =$request->user_id;
          $model->created_date =my_date();
          $model->created_time =my_time();
            if ($model->save()) {
              return response()->json([
                'status' => true,
                'message' => 'Query sent successfully.',
            ]);

            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Query not sent.',  
                ]);
             }            
        }

    


        public function notification_list(Request $request){
        
         $userid  = Auth::user()->id;
          $result = UserTransaction::where('user_id',$userid)->orderBy('id', 'DESC')->get();

          if (count($result) > 0) {
            return response()->json([
              'status' => true,
              'message' => 'Notification list',
              'notification'=>$result
          ]);
          }else{
            return response()->json([
              'status' => false,
              'message' => 'Notification not found.',
            ]);
          }
  
        }
        
}