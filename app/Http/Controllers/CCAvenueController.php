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
        // $userss = Auth::user();
       
        $valid=Validator::make($request->all(),[
        'package_id'=>'required',
        'user_id'=>'required',
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
          
        $ordernumber = "PARI00".rand(1000,9999).$lst;
        
        $package = DB::table('packages')->where('id',$request->package_id)->orderBy('id', 'DESC')->first();
        if(empty($package)){
             return response()->json(['status'=>false,'message'=>'Recahrge package not found.']);
        }
        
        $total = 0;
        
        if($package->amount !=''){
            $total = $package->amount;
        }
        
        $orderstatus = 'Pending';
        
        $user = DB::table('users')->where('id',$request->user_id)->first();
         if(empty($user)){
             return response()->json(['status'=>false,'message'=>'user not found.']);
        }
        
        if($user->name != ''){
            $name = $user->name;
        }else{
            $name = "parihara";
        }
       
        if($user->address != ''){
            $address = $user->address;
        }else{
            $address = "parihara";
        }
        
        if($user->pincode != ''){
            $pincode = $user->pincode;
        }else{
            $pincode = "110022";
        }
        
        if($user->email != ''){
            $email = $user->email;
        }else{
            $email = "110022";
        }
        
        $arr=array(
            "user_id"=>$user->id,
            "order_type"=>"Wallet",
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
                                $input['amount'] = $total;
                                $input['order_id'] = $ordernumber;
                                $input['currency'] = "INR";
                                $input['redirect_url'] = route('cc-response');
                                $input['cancel_url'] = route('cc-response');
                                $input['language'] = "EN";
                                $input['merchant_id'] = '2840771';
                                $input['tid'] = time();
                                $input['billing_name'] =$name;
                                $input['product_id'] = "1";
                                $input['billing_address'] = $address;
                                $input['billing_city'] = '';
                                $input['billing_state'] ='';
                                $input['billing_zip'] =$pincode;
                                $input['billing_country'] = "IN";
                                $input['billing_tel'] = $user->mobile;
                                $input['billing_email'] = $email;
                                $input['delivery_name'] = $name;
                                $input['delivery_address'] = '';
                                $input['delivery_city'] = '';
                                $input['delivery_state'] = '';
                                $input['delivery_zip'] =$pincode;
                                $input['delivery_country'] = "IN";
                                $input['delivery_tel'] = $user->mobile;
                               
                                 // $input['promo_code'] = "";

                                $merchant_data = "";
                            
                                 $working_key = "BB3390BB25E10E18345CCA901BAC56B3"; //Shared by CCAVENUES
                                 $access_code = "AVWS20KJ37AY22SWYA";  //Shared by CCAVENUES
                                // print_r($input);
                              
                                $input['merchant_param1'] = "additional Info."; // optional parameter
                                $input['merchant_param2'] = "additional Info."; // optional parameter
                                $input['merchant_param3'] = "additional Info."; // optional parameter
                                $input['merchant_param4'] = "additional Info."; // optional parameter
                                $input['merchant_param5'] = "additional Info."; // optional parameter
                                // foreach ($input as $key => $value) {
                                //     $merchant_data .= $key . '=' . $value . '&';
                                // }
                                
            return view('ccform',compact('input'));
        }else{
               return response()->json(['status'=>false,'message'=>'Order not placed, please try sometime later.']);
        }
   
       return response()->json(['status'=>false,'message'=>null]); 
    
       }
    }
    
    public function validate_place_order(Request $request){
        // $userss = Auth::user();
       
        $valid=Validator::make($request->all(),[
        'order_number'=>'required',
        'user_id'=>'required',
        ]);
      
       if($valid->fails()){
        return response()->json(['status'=>'error','error'=>$valid->errors()->toArray()]);
       }
         
     
        $ordercheck = DB::table('orders')->where('order_number',$request->order_number)->first();
         
        if(empty($ordercheck)){
             return response()->json(['status'=>false,'message'=>'Order not found.']);
        }
        
                            
                                $input['amount'] = $ordercheck->grand_total;
                                $input['order_id'] = $ordercheck->order_number;
                                $input['currency'] = "INR";
                                $input['redirect_url'] = route('cc-response');
                                $input['cancel_url'] = route('cc-response');
                                $input['language'] = "EN";
                                $input['merchant_id'] = '2840771';
                                $input['tid'] = time();
                                $input['billing_name'] =$ordercheck->full_name;
                                $input['product_id'] = "1";
                                $input['billing_address'] = $ordercheck->house_no ;
                                $input['billing_city'] = '';
                                $input['billing_state'] ='';
                                $input['billing_zip'] =$ordercheck->pincode;
                                $input['billing_country'] = "IN";
                                $input['billing_tel'] = $ordercheck->mobile;
                                $input['billing_email'] = "contact@theparihara.com";
                                $input['delivery_name'] = $ordercheck->full_name;
                                $input['delivery_address'] = '';
                                $input['delivery_city'] = '';
                                $input['delivery_state'] = '';
                                $input['delivery_zip'] =$ordercheck->pincode;
                                $input['delivery_country'] = "IN";
                                $input['delivery_tel'] = $ordercheck->mobile;
                               
                                 // $input['promo_code'] = "";

                                $merchant_data = "";
                            
                                 $working_key = "BB3390BB25E10E18345CCA901BAC56B3"; //Shared by CCAVENUES
                                 $access_code = "AVWS20KJ37AY22SWYA";  //Shared by CCAVENUES
                                // print_r($input);
                              
                                $input['merchant_param1'] = "additional Info."; // optional parameter
                                $input['merchant_param2'] = "additional Info."; // optional parameter
                                $input['merchant_param3'] = "additional Info."; // optional parameter
                                $input['merchant_param4'] = "additional Info."; // optional parameter
                                $input['merchant_param5'] = "additional Info."; // optional parameter
                                // foreach ($input as $key => $value) {
                                //     $merchant_data .= $key . '=' . $value . '&';
                                // }
                                
            return view('ccform',compact('input'));
    }
    
    public function purchaseSubscription(Request $request){
  
                            
                                $input = $request->all();
                               

                                $merchant_data = "";
                            
                                 $working_key = "BB3390BB25E10E18345CCA901BAC56B3"; //Shared by CCAVENUES
                                 $access_code = "AVWS20KJ37AY22SWYA";  //Shared by CCAVENUES
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
                                $url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . $access_code;
                           
            return redirect($url);
      
    }
    
    public function ccResponse(Request $request){
       
            try {
             
             
                $workingKey = "BB3390BB25E10E18345CCA901BAC56B3";  //Working Key should be provided here.
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
                    $order_status1 ="";
                   if($order_status==="Success")
                   {
                       $redirect = true;
                      $printMessage ="Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
                   
                    $data=array('payment_status'=>'Success','transaction_id'=>$bankRef,'order_status'=>'Success','status'=>1);
                    $order_status1 ="Success";
                   }
                   else if($order_status==="Aborted")
                   {
                     $redirect = false;
                     $printMessage = "Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
                     $data=array('payment_status'=>'Aborted','order_status'=>'Failed','status'=>1);
                   
                        $order_status1 ="Aborted";
                   }
                   else if($order_status==="Failure")
                   {
                     $redirect = false;
                     $printMessage = "Thank you for shopping with us.However,the transaction has been declined.";
                    $data=array('payment_status'=>'Failure','order_status'=>'Failed','status'=>1);
                    $order_status1 ="Failure";
                   }
                   else
                   {
                      $redirect = false;
                      $printMessage = "Security Error. Illegal access detected";
                     $data=array('payment_status'=>'Failure','order_status'=>'Failed','status'=>1);
                     $order_status1 ="Failure";
                   }
                
                
                 $getorder  = DB::table('orders')->where(['order_number'=>$order_id])->first();
                 if(!empty($getorder)){
                    $orderupdate =  DB::table('orders')->where(['order_number'=>$order_id])->update($data);
                    if($getorder->order_type == 'Wallet'){
                         if($orderupdate){
                        
                             $user = DB::table('users')->where('id',$getorder->user_id)->first(); 
                             $amount = $user->wallet_amount + (int)$getorder->grand_total;
                             
                             if($order_status1 == 'Success'){
                                 $userUpdate = DB::table('users')->where('id',$getorder->user_id)->update(array('wallet_amount'=>$amount)); 
                             }
                             
                        }
                    }
                    
                   
                     
                      
                 }
                
                $viewArray['order_status'] =$order_status1; 
                
                return view('ccresponse',$viewArray);
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
        
}
