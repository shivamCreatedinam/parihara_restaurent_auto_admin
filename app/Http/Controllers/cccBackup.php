<?php

namespace App\Http\Controllers;
use App\Models\UserTransaction;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Auth;
class CCAvenueController extends Controller
{
    
    public function indexCC(Request $request){
      return view('cc/main');
    }
    public function senddataCC(Request $request){
      
        $merchant_data='';
        $working_key = "3837663E0F7B727B6D4284C821FCFEA9"; //Shared by CCAVENUES
        $access_code = "AVYC13KI70BH27CYHB"; 
    // 	$working_key = CCA_WORKING_KEY;
    // 	$access_code = CCA_ACCESS_CODE;
        $orderId = "123444";
    	foreach ($_POST as $key => $value){
    	    if($key !='_token'){
    	    $merchant_data.=$key.'='.$value.'&';    
    	    }
    		
    	}
    	$merchant_data .= "order_id=".$orderId;
      
    	$encrypted_data=$this->myencrypt($merchant_data,$working_key); 
       // echo $encrypted_data;
    }
    
    
   public  function myencrypt($plainText,$key)
	{
		$secretKey = $this->myhextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
		$plainPad = $this->pkcs5_pad($plainText, $blockSize);
	  	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
		{
		      $encryptedText = mcrypt_generic($openMode, $plainPad);
	      	      mcrypt_generic_deinit($openMode);
		      			
		} 
		return bin2hex($encryptedText);
	}
	
	 function pkcs5_pad ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}

    public	function myhextobin($hexString) 
   	 { 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
    	  } 



    public function place_order(Request $request){
        $user = Auth::user();
        $userid = Auth::user()->id;
        $valid=Validator::make($request->all(),[
        'package_id'=>'required',
        ]);
      
       if($valid->fails()){
        return response()->json(['status'=>'error','error'=>$valid->errors()->toArray()]);
       }else{
         
     
         $last2 = DB::table('orders')->select('id')->orderBy('id', 'DESC')->first();
            if (!empty($last2)) {
                $lst = $last2->id+1;
            }else{
                $lst = 1;
            }
          
        $ordernumber = "MNH00".rand(1000,9999).$lst;
        
        $package = DB::table('packages')->where('id',$request->package_id)->orderBy('id', 'DESC')->first();
        if(empty($package)){
             return response()->json(['status'=>false,'message'=>'Recahrge package not found.']);
        }
        
        $total = "";
        
        if($package->amount !=''){
            $total = $package->amount;
        }
        
        $orderstatus = 'Pending';
        
        $arr=array(
            "user_id"=>$userid,
            "order_number"=>$ordernumber,
            "address_id"=>0,
            "sub_total"=>$total,
            "grand_total"=>$total,
            "full_name"=>$user->name,
            "mobile"=>$user->mobile,
           
            "house_no"=>$user->address,
            "appartment"=>$user->address,
            "state"=>'',
            "city"=>'',
            "pincode"=>$user->pincode,
            "address_type"=>"Home",
            "order_status"=>$orderstatus,
            "payment_status"=>"Pending",
            'payment_mode'=>'ONLINE',
            "status"=>0,
            "applied_coupon_code"=>'NO',
            "discount_value"=>'0',
            "discount_amount"=>'0',
            
            "delvery_charge"=>0,
            "slot_id"=>0,
            "selected_slot"=>0,
            "address_id"=>0,
            "created_date"=>date('Y-m-d H:i:s'),
            "created_time"=>time()
        );
        
        $order_id=DB::table('orders')->insertGetId($arr); 
        
        if ($order_id > 0) {
           
              
                            
                                //  $input['amount'] = $grandtotal;
                                $input['amount'] = 1;
                                $input['order_id'] = $ordernumber;
                                $input['currency'] = "INR";
                                $input['redirect_url'] = route('cc-response');
                                $input['cancel_url'] = route('cc-response');
                                $input['language'] = "EN";
                                $input['merchant_id'] = '2840771';
                                $input['tid'] = time();
                                $input['billing_name'] = $user->address;
                                $input['product_id'] = "1";
                                $input['billing_address'] = $user->address;
                                $input['billing_city'] = '';
                                $input['billing_state'] ='';
                                $input['billing_zip'] = '';
                                $input['billing_country'] = "IN";
                                $input['billing_tel'] = $user->mobile;
                                $input['billing_email'] = $user->email;
                                $input['delivery_name'] = $user->name;
                                $input['delivery_address'] = '';
                                $input['delivery_city'] = '';
                                $input['delivery_state'] = '';
                                $input['delivery_zip'] = '';
                                $input['delivery_country'] = "IN";
                                $input['delivery_tel'] = $user->mobile;
                               
                                 // $input['promo_code'] = "";

                                $merchant_data = "";
                            
                                 $working_key = "3793DAB3B2321F93A66A98DE3C8BEE4F"; //Shared by CCAVENUES
                                 $access_code = "AVHN05KJ26AY62NHYA";  //Shared by CCAVENUES
                                // print_r($input);
                              
                                $input['merchant_param1'] = "additional Info."; // optional parameter
                                $input['merchant_param2'] = "additional Info."; // optional parameter
                                $input['merchant_param3'] = "additional Info."; // optional parameter
                                $input['merchant_param4'] = "additional Info."; // optional parameter
                                $input['merchant_param5'] = "additional Info."; // optional parameter
                                foreach ($input as $key => $value) {
                                    $merchant_data .= $key . '=' . $value . '&';
                                }
                                
                                // $url='';
                                // $encrypted_data = $this->encryptCC($merchant_data, $working_key);
                                // $url = 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . $access_code;
                           
         
            return view('ccform',compact('input'));
        }else{
               return response()->json(['status'=>false,'message'=>'Order not placed, please try sometime later.']);
        }
  
   
   
       return response()->json(['status'=>false,'url'=>'']); 
    
       }
    }
    public function purchaseSubscription(Request $request){
        $user = Auth::user();
        $userid = Auth::user()->id;
        $valid=Validator::make($request->all(),[
        'package_id'=>'required',
        ]);
      
       if($valid->fails()){
        return response()->json(['status'=>'error','error'=>$valid->errors()->toArray()]);
       }else{
         
     
         $last2 = DB::table('orders')->select('id')->orderBy('id', 'DESC')->first();
            if (!empty($last2)) {
                $lst = $last2->id+1;
            }else{
                $lst = 1;
            }
          
        $ordernumber = "MNH00".rand(1000,9999).$lst;
        
        $package = DB::table('packages')->where('id',$request->package_id)->orderBy('id', 'DESC')->first();
        if(empty($package)){
             return response()->json(['status'=>false,'message'=>'Recahrge package not found.']);
        }
        
        $total = "";
        
        if($package->amount !=''){
            $total = $package->amount;
        }
        
        $orderstatus = 'Pending';
        
        $arr=array(
            "user_id"=>$userid,
            "order_number"=>$ordernumber,
            "address_id"=>0,
            "sub_total"=>$total,
            "grand_total"=>$total,
            "full_name"=>$user->name,
            "mobile"=>$user->mobile,
           
            "house_no"=>$user->address,
            "appartment"=>$user->address,
            "state"=>'',
            "city"=>'',
            "pincode"=>$user->pincode,
            "address_type"=>"Home",
            "order_status"=>$orderstatus,
            "payment_status"=>"Pending",
            'payment_mode'=>'ONLINE',
            "status"=>0,
            "applied_coupon_code"=>'NO',
            "discount_value"=>'0',
            "discount_amount"=>'0',
            
            "delvery_charge"=>0,
            "slot_id"=>0,
            "selected_slot"=>0,
            "address_id"=>0,
            "created_date"=>date('Y-m-d H:i:s'),
            "created_time"=>time()
        );
        
        $order_id=DB::table('orders')->insertGetId($arr); 
        
        if ($order_id > 0) {
           
              
                            
                                //  $input['amount'] = $grandtotal;
                                $input['amount'] = 1;
                                $input['order_id'] = $ordernumber;
                                $input['currency'] = "INR";
                                $input['redirect_url'] = route('cc-response');
                                $input['cancel_url'] = route('cc-response');
                                $input['language'] = "EN";
                                $input['merchant_id'] = '2840771';
                                $input['tid'] = time();
                                $input['billing_name'] = $user->address;
                                $input['product_id'] = "1";
                                $input['billing_address'] = $user->address;
                                $input['billing_city'] = '';
                                $input['billing_state'] ='';
                                $input['billing_zip'] = '';
                                $input['billing_country'] = "IN";
                                $input['billing_tel'] = $user->mobile;
                                $input['billing_email'] = $user->email;
                                $input['delivery_name'] = $user->name;
                                $input['delivery_address'] = '';
                                $input['delivery_city'] = '';
                                $input['delivery_state'] = '';
                                $input['delivery_zip'] = '';
                                $input['delivery_country'] = "IN";
                                $input['delivery_tel'] = $user->mobile;
                               
                                 // $input['promo_code'] = "";

                                $merchant_data = "";
                            
                                 $working_key = "3793DAB3B2321F93A66A98DE3C8BEE4F"; //Shared by CCAVENUES
                                 $access_code = "AVHN05KJ26AY62NHYA";  //Shared by CCAVENUES
                                // print_r($input);
                              
                                $input['merchant_param1'] = "additional Info."; // optional parameter
                                $input['merchant_param2'] = "additional Info."; // optional parameter
                                $input['merchant_param3'] = "additional Info."; // optional parameter
                                $input['merchant_param4'] = "additional Info."; // optional parameter
                                $input['merchant_param5'] = "additional Info."; // optional parameter
                                foreach ($input as $key => $value) {
                                    $merchant_data .= $key . '=' . $value . '&';
                                }
                                
                                $url='';
                                $encrypted_data = $this->encryptCC($merchant_data, $working_key);
                                $url = 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . $access_code;
                            // DB::table('orders')->where(['id'=>$order_id])->update($updata);
                  
               
                    
                    // $tran = UserTransaction::insert(
                    // array(
                    //     'user_id'=>$uid,
                    //     'titles'=>'Order No.#'.$ordernumber.' placed successfully.',
                    //     'remark'=>'Order No.#'.$ordernumber.' placed successfully , your order in processing.',
                    //     'created_date'=>my_date(),
                    //     'created_time'=>my_time(),
                    // ));
                    // $insert_status = DB::table('ordered_status')->insert(array(
                    // 'user_id'=>$uid,
                    // 'order_number'=>$ordernumber,
                    // 'order_sort'=>'1',
                    // 'order_status'=>'Processing',
                    // 'created_date'=>my_date(),
                    // 'created_time'=>my_time()
                    // ));

            //   return response()->json(['status'=>true,'message'=>'Order placed','order_number'=>$ordernumber,'url'=>$url]); 
            return redirect($url);
        }else{
               return response()->json(['status'=>false,'message'=>'Order not placed, please try sometime later.']);
        }
  
   
   
       return response()->json(['status'=>false,'url'=>'']); 
    
       }
    }
    
    public function ccResponse(Request $request){
       
            try {
             
             
                $workingKey = "3793DAB3B2321F93A66A98DE3C8BEE4F";  //Working Key should be provided here.
                $encResponse = $_POST["encResp"];
        
                $rcvdString = $this->decryptCC($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
                $order_status = "";
                $decryptValues = explode('&', $rcvdString);
                
                $dataSize = sizeof($decryptValues);
                    $bankRef="";
                
                   for($i = 0; $i < $dataSize; $i++) 
                   {
                      $information=explode('=',$decryptValues[$i]);
                      if($i==3)  $order_status=$information[1];
                      if($i==0)  $order_id=$information[1];
                      if($i==10)  $Amounts=$information[1];
                      if($i==2)  $bankRef=$information[1];
                   }
                   
                  
                    $showInfo ="";
                    $redirect = false;
                    $printMessage="";
                   if($order_status==="Success")
                   {
                       $redirect = true;
                      $printMessage ="Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
                   
                    $data=array('payment_status'=>'Success','transaction_status'=>'Success','transaction_id'=>$bankRef,'transaction_signature'=>"",'order_status'=>'Processing','status'=>1);
                    
                   }
                   else if($order_status==="Aborted")
                   {
                     $redirect = false;
                     $printMessage = "Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
                     $data=array('payment_status'=>'Aborted','transaction_status'=>'Aborted','transaction_id'=>"",'transaction_signature'=>"",'order_status'=>'Pending','status'=>0);
                   }
                   else if($order_status==="Failure")
                   {
                     $redirect = false;
                     $printMessage = "Thank you for shopping with us.However,the transaction has been declined.";
                     $data=array('payment_status'=>'Failure','transaction_status'=>'Failure','transaction_id'=>"",'transaction_signature'=>"",'order_status'=>'Pending','status'=>0);
                   }
                   else
                   {
                      $redirect = false;
                      $printMessage = "Security Error. Illegal access detected";
                      $data=array('payment_status'=>'Failed','transaction_status'=>'Failed','transaction_id'=>"",'transaction_signature'=>"",'order_status'=>'Pending','status'=>0);
                   }
                   
                   $showInfo .= "<table cellspacing=4 cellpadding=4>";
                   for($i = 0; $i < $dataSize; $i++) 
                   {
                        $information=explode('=',$decryptValues[$i]);
                        $showInfo .='<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
                   }
                   $showInfo .= "</table><br>";
                   
                
                 $getorder  = DB::table('orders')->where(['order_number'=>$order_id])->first();
                 if(!empty($getorder)){
                     // DB::table('orders')->where(['order_number'=>$order_id])->update($data);
                    //  $user = DB::table('users')->where('id',$getorder->user_id)->first();
                      
                 }
                 $viewArray['showinfo'] =$showInfo; 
                 $viewArray['print_message'] =$printMessage; 
                 $viewArray['order_number'] =$order_id; 
                 $viewArray['amount'] =$Amounts; 
                 if($redirect == true){
                      return response()->json([
                    'status' => true,
                    'message' => 'Transaction response.',
                    'data' => $viewArray,
                        ]);
                     
                 }else{
                       return response()->json([
                    'status' => true,
                    'message' => 'Transaction response.',
                    'data' => $viewArray,
                        ]);
                 }
            }
            
            //catch exception
            catch(Exception $e) {
              echo 'Message: ' .$e->getMessage();
            }
    }
    
    
public function encryptCC($plainText, $key)
{
    $key = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    $encryptedText = bin2hex($openMode);
    return $encryptedText;
}

public function decryptCC($encryptedText, $key)
{
    $key = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText = $this->hextobin($encryptedText);
    $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    return $decryptedText;
}

public function pkcs5_padCC($plainText, $blockSize)
{
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    return $plainText . str_repeat(chr($pad), $pad);
}

public function hextobin($hexString)
{
    $length = strlen($hexString);
    $binString = "";
    $count = 0;
    while ($count < $length) {
        $subString = substr($hexString, $count, 2);
        $packedString = pack("H*", $subString);
        if ($count == 0) {
            $binString = $packedString;
        } else {
            $binString .= $packedString;
        }

        $count += 2;
    }
    return $binString;
}

 public function apply_promocode(Request $request){
            $uid=session()->get('FRONT_USER_ID');
            $validator = Validator::make($request->all(), [
            'promocode' => 'required',
                ]);
              if ($validator->fails()) {
                    return response()->json(['error' => $validator->messages()], 200);
                }
            
                 if (user_exist($uid)) {
                  
                  $promocode =  check_promocode($request->promocode);
        
                
                  $total=DB::table('cart')
                      ->where(['user_id'=>$uid])
                      ->where(['user_type'=>"Reg"])
                      ->sum('total_price');
        
                      $cartcount =  DB::table('cart')->where(['user_id'=>$uid,'user_type'=>'Reg'])->count();
        
                      if ($cartcount <= 0) {
                          return response()->json([
                                      'status' => false,
                                      'message' => 'Empty cart.',
                               ]);
                      }
        
                  if (!empty($promocode)) {
                    if (date('Y-m-d H:i:s') >= date('Y-m-d H:i:s',strtotime($promocode->valid_from))  && date('Y-m-d H:i:s') <= date('Y-m-d H:i:s',strtotime($promocode->expires_on))) {
                      if ($promocode->user_type == 'Selected-User') {
                          $selectcount = DB::table('coupon_selected_users')
                          ->where('user_id',$uid)
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
                            if((int)$promocode->min_cart_amount  > (int)$total){
                                 return response()->json([
                                      'status' => false,
                                      'message' => 'You are not able to use this coupon code,you have less cart amount.',
                               ]);
                            }
                            if((int)$promocode->discount  > $total){
                                 return response()->json([
                                      'status' => false,
                                      'message' => 'You are not able to use this coupon code,you have less cart amount for this coupon',
                               ]);
                            }
                          $discounted = $total - (int)$promocode->discount;
                          
                          $discountedval = (int)$promocode->discount;
                        }
                        if ($promocode->discount_type == 'Percentage') {
                            if((int)$promocode->min_cart_amount  > (int)$total){
                                 return response()->json([
                                      'status' => false,
                                      'message' => 'You are not able to use this coupon code,you have less cart amount.',
                               ]);
                            }
                        
                         $discountedAmonutd  =  ($total * (int)$promocode->discount/100);
                         if((int)$discountedAmonutd > (int)$promocode->max_discount){
                              $discountedval=$promocode->max_discount;
                         }else{
                              $discountedval=$discountedAmonutd;
                         }
                        
                          $discounted = $total -  $discountedval;
                        }
        
                       
                        return response()->json([
                            'status' => true,
                            'cartamount'=>"$total",
                            'discounted_value'=>"$discountedval",
                            'dd'=>(int)$promocode->discount,
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
        
}
