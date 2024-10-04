<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use App\Models\TravelRequest;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverAuthController extends Controller
{
    public function register(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10|max:10|unique:drivers',
            'email' => 'required|unique:drivers',
            'name' => 'required',
            'vehicle_no' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'aadhar_front' => 'required',
            'aadhar_back' => 'required',
            'drv_licence' => 'required',
            'password' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        //   $otp=DB::table('otp_verification')  
        //     ->where(['mobile'=>$request->mobile])
        //     ->where(['otp'=>$request->otp])
        //     ->first(); 
            
        //     if(empty($otp) || $otp ==null){
        //          return response()->json([
        //             'status' => false,
        //             'message' => 'You entered wrong otp.',
        //         ]);
        //     }
        
           $result=DB::table('drivers')  
            ->where(['mobile'=>$request->mobile])
            ->where(['email'=>$request->email])
            ->first();  
          
       
        if(!empty($result)){
           
           
            // if (Auth::loginUsingId($result->id) && $result->id > 0) {
            //     $user  = Auth::user();
            //     $token = $user->createToken('Parihara')->plainTextToken;
    
                // if($request->firbase_token !=''){
                //     $upd=DB::table('users')  
                //     ->where('id',$user->id)
                //     ->update(['firbase_token'=>$request->firbase_token]); 
                //     }
            // $delete=DB::table('otp_verification')  
            // ->where(['mobile'=>$request->mobile])
            // ->delete(); 
                return response()->json([
                    'status' => false,
                    'message' => 'driver already exists.',
                ]);
            // }
           
        }else{
            $getid = DB::table('drivers')->orderBy('id','DESC')->first();
          
            if(!empty($getid)){
                $maxid = $getid->id;        
            }else{
                $maxid = 1;
            }
            $u = $maxid+1;
            $UID = "DRV0".$u; 
        
        $model = new Driver();
        $model->driver_id = $UID;
        $model->duty_status = "Off";
        $model->name =$request->name;
        $model->email =$request->email;
        $model->mobile =$request->mobile;
        $model->password = Hash::make($request->password);
        $model->temp_pass = $request->password;
        $model->drv_image ="uploads/user_image/user.png";
        $model->vehicle_no = $request->vehicle_no;
        $model->address = $request->address;
        $model->latitude = $request->latitude;
        $model->longitude = $request->longitude;
        if($request->hasfile('insurence_file')){
            $image = $request->file('insurence_file');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
           
            $image->move(public_path('uploads/insurence_image'), $image_name);
            $model->insurance_file = "uploads/insurence_image/".$image_name;
        }
        if($request->hasfile('aadhar_front')){
            $image = $request->file('aadhar_front');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
           
            $image->move(public_path('uploads/aadhar_image'), $image_name);
            $model->aadhar_front = "uploads/aadhar_image/".$image_name;
        }
        if($request->hasfile('aadhar_back')){
            $imageback = $request->file('aadhar_back');
            $extback = $imageback->extension();
            $image_nameback = time().'.'.$extback;
           
            $imageback->move(public_path('uploads/aadhar_image'), $image_nameback);
            $model->aadhar_back = "uploads/aadhar_image/".$image_nameback;
        }
        if($request->hasfile('drv_licence')){
            $imagelicec = $request->file('drv_licence');
            $extlicec = $imagelicec->extension();
            $image_namelicec = time().'.'.$extlicec;
           
            $imagelicec->move(public_path('uploads/licence_image'), $image_namelicec);
            $model->drv_licence = "uploads/licence_image/".$image_namelicec;
        }
        
        $model->firbase_token =NULL;
        $model->created_date=date('Y-m-d H:i:s');
        $model->status=0;
        $model->verified="No";
       

        //User created, return success response
           if ($model->save()) {
            // $token = $model->createToken('Parihara')->plainTextToken;
            
            // $delete=DB::table('otp_verification')  
            // ->where(['mobile'=>$request->mobile])
            // ->delete(); 
            
            
            return response()->json([
            'status' => true,
            'name' => $model->name,
            'message' => 'Driver registered successfully',
            // 'token' => $token,
            'id'=>$model->id,
                ]);
           }else{
            return response()->json([
            'status' => false,
            'message' => 'Something wrong !',
            ]);
           }
        
        }
        
    }
    public function updateProfileDrv(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'mobile' => "required|min:10|max:10|unique:drivers,mobile,$request->driver_id,id",
            'email' => "required|unique:drivers,email,$request->driver_id,id",
            'name' => 'required',
            'vehicle_no' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        
           $result=DB::table('drivers')  
            ->where(['id'=>$request->driver_id])
            ->first();  
          
       
        if(!empty($result)){
            
            $model =  Driver::find($request->driver_id);
            $model->name =$request->name;
            $model->email =$request->email;
            $model->mobile =$request->mobile;
            $model->vehicle_no = $request->vehicle_no;
            $model->address = $request->address;
            if($request->latitude !=''){
            $model->latitude = $request->latitude;    
            }
            if($request->longitude !=''){
            $model->longitude = $request->longitude;   
            }
        
            
            // if($request->hasfile('aadhar_front')){
            //     $image = $request->file('aadhar_front');
            //     $ext = $image->extension();
            //     $image_name = time().'.'.$ext;
               
            //     $image->move(public_path('uploads/aadhar_image'), $image_name);
            //     $model->aadhar_front = "uploads/aadhar_image/".$image_name;
            // }
            // if($request->hasfile('aadhar_back')){
            //     $imageback = $request->file('aadhar_back');
            //     $extback = $imageback->extension();
            //     $image_nameback = time().'.'.$extback;
               
            //     $imageback->move(public_path('uploads/aadhar_image'), $image_nameback);
            //     $model->aadhar_back = "uploads/aadhar_image/".$image_nameback;
            // }
            // if($request->hasfile('drv_licence')){
            //     $imagelicec = $request->file('drv_licence');
            //     $extlicec = $imagelicec->extension();
            //     $image_namelicec = time().'.'.$extlicec;
               
            //     $imagelicec->move(public_path('uploads/licence_image'), $image_namelicec);
            //     $model->drv_licence = "uploads/licence_image/".$image_namelicec;
            // }
            
            // $model->firbase_token =NULL;
            // $model->created_date=date('Y-m-d H:i:s');
            // $model->status=0;
            // $model->verified="No";
           

        //User created, return success response
           if ($model->save()) {
            return response()->json([
            'status' => true,
            'message' => 'Driver updated successfully',
            ]);
           }else{
            return response()->json([
            'status' => false,
            'message' => 'Not updated!',
            ]);
           }
        
        }else{
            return response()->json([
                    'status' => false,
                    'message' => 'driver not exists.',
                ]); 
        }
        
    }
    
     public function updateFcmToken(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'token'=>'required',
             'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
                
                $model = Driver::find($request->driver_id);
                $model->firbase_token = $request->token;
                if($model->save()){
                 return response()->json([
                'status' => true,
                'message' => 'token updated successfully.',
                 ]);
   
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'token already updated',
                         ]);

                }
                 
        
    }
    
    public function updateDriverLatLong(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'latitude'=>'required',
            'longitude'=>'required',
             'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
                
                $model = Driver::find($request->driver_id);
                $model->latitude = $request->latitude;
                $model->longitude = $request->longitude;
                if($model->save()){
                 return response()->json([
                'status' => true,
                'message' => 'lat long updated successfully.',
                 ]);
   
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'lat long already updated',
                         ]);

                }
                 
        
    }
    
    public function updateDrvDocument(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'vehicle_no' => 'required',
            'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
           $result=DB::table('drivers')  
            ->where(['id'=>$request->driver_id])
            ->where(['status'=>'1'])
            ->first();  
          
       
        if(empty($result)){
         
                return response()->json([
                    'status' => false,
                    'message' => 'driver not exists.',
                ]);
           
        }
            
        $model = Driver::find($request->driver_id);
     
        $model->vehicle_no = $request->vehicle_no;
        if($request->hasfile('drv_licence')){
            $imagelicec = $request->file('drv_licence');
            $extlicec = $imagelicec->extension();
            $image_namelicec = time().'.'.$extlicec;
           
            $imagelicec->move(public_path('uploads/licence_image'), $image_namelicec);
            $model->drv_licence = "uploads/licence_image/".$image_namelicec;
        }
        
        
        //User created, return success response
           if ($model->save()) {
          
            return response()->json([
            'status' => true,
            'message' => 'Details updated successfully',
                ]);
           }else{
            return response()->json([
            'status' => false,
            'message' => 'Something wrong !',
            ]);
           }
        
        
        
    }
    
    public function getTripSuccessAmount(Request $request){
       
       
       
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
      
     
         $cashamount='0';
         $walletamount='0';
         $query = "SELECT SUM(price) as cashamount FROM travel_requests WHERE trip_type ='cash' AND driver_id='".$request->driver_id."' AND otp_verified='1'  AND status='3' ";
         $resultcash = DB::select($query);
            
        if(count($resultcash) > 0){
            if($resultcash[0]->cashamount != null){
            $cashamount = $resultcash[0]->cashamount;    
            }
            
        }
        
        
         $wallquery = "SELECT SUM(price) as walletamount FROM travel_requests WHERE trip_type ='wallet' AND driver_id='".$request->driver_id."' AND otp_verified='1'  AND status='3' ";
        $resultwallet = DB::select($wallquery);
        
        if(count($resultwallet) > 0){
            if($resultwallet[0]->walletamount !=null){
            $walletamount = $resultwallet[0]->walletamount;    
            }
            
        }
        
        
       return response()->json([
                'status' => true,
                'message' => 'success trip amount.',
                'wallet_Amount'=>$walletamount,
                'cash_Amount'=>$cashamount,
            ]);
    }
     public function travelRequestList(Request $request){
       
          $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
      
          
        $data = TravelRequest::where('driver_id',$request->driver_id)->whereIn('status',[1,2,3])->orderBy('id','DESC')->get();
             
          if(count($data) > 0){
              
            return response()->json([
                'status' => true,
                'message' => 'my trip list.',
                'data'=>$data
            ]);
            
          }else{
            return response()->json([
                'status' => false,
                'message' => 'something went wrong!'
            ]);
          }
    }
    
    public function updateDrvProfile(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            // 'mobile' => 'required|min:10|max:10',
            // 'email' => 'required',
            // 'name' => 'required',
            // 'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
       
           $result=DB::table('drivers')  
            ->where('id',$request->driver_id)
            ->where('status','1')
            ->where('verified','Yes')
            ->first();  
          
       
        if(empty($result)){
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong!',
                ]);
        }
        $model =Driver::find($request->driver_id);
        $model->name =$request->name;
        $model->email =$request->email;
        $model->mobile =$request->mobile;
        $model->address = $request->address;
        $model->latitude = $request->latitude;
        $model->longitude = $request->longitude;
        if($request->hasfile('aadhar_front')){
            $image = $request->file('aadhar_front');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
           
            $image->move(public_path('uploads/aadhar_image'), $image_name);
            $model->aadhar_front = "uploads/aadhar_image/".$image_name;
        }
        if($request->hasfile('aadhar_back')){
            $imageback = $request->file('aadhar_back');
            $extback = $imageback->extension();
            $image_nameback = time().'.'.$extback;
           
            $imageback->move(public_path('uploads/aadhar_image'), $image_nameback);
            $model->aadhar_back = "uploads/aadhar_image/".$image_nameback;
        }
       

        //User created, return success response
           if ($model->save()) {
         
            return response()->json([
            'status' => true,
            'name' => $model->name,
            'message' => 'Driver profile updated successfully',
            ]);
           }else{
            return response()->json([
            'status' => false,
            'message' => 'Something went wrong !',
            ]);
           }
    }
    
     public function otpUpdatePassword(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10|max:10',
            'otp' => 'required|min:4|max:4',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
          
       
          $result=DB::table('drivers')  
            ->orWhere(['mobile'=>$request->mobile])
            ->first(); 
       
        if(!empty($result)){
            
            $otp=DB::table('otp_verification')  
            ->where(['mobile'=>$request->mobile])
            ->where(['otp'=>$request->otp])
            ->first(); 
            
            if(empty($otp) || $otp == null){
                 return response()->json([
                    'status' => false,
                    'message' => 'You entered wrong otp.',
                ]);
            }
            
            if ($request->new_password != $request->confirm_password) {
                return response()->json([
                    'status' => false,
                    'message' => 'Confirm password not matching.',
                ]);
            }

            $update = array(
                'password'=>bcrypt($request->new_password),
              );
               $updt1 = DB::table('drivers')
              ->where('mobile',$request->mobile)
              ->update($update);

            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully.',
                
            ]);
        }else{
           return response()->json([
                    'status' => false,
                    'message' => 'Please enter registered mobile number.',
                ]);
        }
    }
    
    public function authenticate(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
           
            'email' => 'required',
            'password' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
       
        
           $result=DB::table('drivers')  
           ->select('id','name','email','mobile','driver_id','duty_status','drv_image','vehicle_no','address','latitude','longitude','aadhar_front','aadhar_back','drv_licence','password')
            ->where(['email'=>$request->email])
            // ->where(['status'=>1])
            //  ->where(['verified'=>'Yes'])
            ->first();  
         
        if(!empty($result)){
            
            if (Hash::check($request->password, $result->password)){
                     return response()->json([
                    'status' => true,
                    'message' => 'logged in successfully.',
                    'driver'=>$result
                     ]);
            }else{
                    
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials!',
                ]);
            }
                    
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials!',
                ]);
        }
           
    }
    public function get_profile(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
       
        
           $result=DB::table('drivers')  
           ->select('id','name','email','mobile','driver_id','duty_status','drv_image','vehicle_no','address','latitude','longitude','aadhar_front','aadhar_back','drv_licence','insurance_file','password','status','verified')
            ->where(['id'=>$request->driver_id])
            // ->where(['status'=>1])
            //  ->where(['verified'=>'Yes'])
            ->first();  
         
        if(!empty($result)){
            if($result->status == 0 && $result->verified == 'No'){
                 return response()->json([
                'status' => false,
                'driver_activated'=>false,
                'message' => 'Your account is not activated from adminstrator. for any query please contact to adminstrator.',
                ]);
            }
           return response()->json([
                    'status' => true,
                    'driver_activated'=>true,
                    'message' => 'driver profile.',
                    'driver'=>$result
                ]);
                    
        }else{
            return response()->json([
                'status' => false,
                'driver_activated'=>false,
                'message' => 'Invalid credentials!',
                ]);
        }
           
    }
    
    public function duty_on_off(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
           
            'driver_id' => 'required',
            'status' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
       
        
           $result=DB::table('drivers')  
            ->where(['id'=>$request->driver_id])
            // ->where(['status'=>1])
            // ->where(['verified'=>'Yes'])
            ->first();  
          $array = ['On','Off'];
       

        if(!empty($result)){
             if($result->status == 0 && $result->verified == 'No'){
                 return response()->json([
                'status' => false,
                'message' => 'Your account in not activated from adminstrator. for any query please contact to adminstrator.',
                ]);
            }
           if (in_array($request->status,$array)) {
            
            $model =Driver::find($request->driver_id);
            $model->duty_status = $request->status;
            if ($model->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Duty '.$request->status.' Successfully.',
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong!',
                ]);
            }
                    
           }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid details !',
                ]);
           }
            // }
           
        }else{
          
            return response()->json([
            'status' => false,
            'message' => 'Something wrong !',
            ]);
           
        }
        
    }
    
    
     public function getActiveStatus(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
       
        
           $result=DB::table('drivers')  
           ->select('duty_status','status')
            ->where(['id'=>$request->driver_id])
            // ->where(['status'=>1])
            //  ->where(['verified'=>'Yes'])
            ->first();  
         
        if(!empty($result)){
            if($result->status == 0 && $result->verified == 'No'){
                 return response()->json([
                'status' => false,
                'driver_activated'=>false,
                'message' => 'Your account is not activated from adminstrator. for any query please contact to adminstrator.',
                ]);
            }
            if($result->status == 2){
                 return response()->json([
                'status' => false,
                'driver_activated'=>false,
                'message' => 'Your account is blocked from adminstrator. for any query please contact to adminstrator.',
                ]);
            }
           return response()->json([
                    'status' => true,
                    'driver_activated'=>true,
                    'message' => 'driver profile.',
                    'driver'=>$result
                ]);
                    
        }else{
            return response()->json([
                'status' => false,
                'driver_activated'=>false,
                'message' => 'Invalid credentials!',
                ]);
        }
           
    }
    
    
    public function update_profile_image(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required',
            'driver_id'=>'required',
            'image'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $count = Driver::where('id',$request->driver_id)->count();
        if($count == 0){
             return response()->json([
                'status' => false,
                'message' => 'invalid driverid.'
            ]);
        }
        $model = Driver::find($request->driver_id);
          if($request->hasfile('image')){
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
           
            $image->move(public_path('uploads/user_image'), $image_name);
            $model->drv_image = "uploads/user_image/".$image_name;
        }else{
            $model->drv_image = "uploads/user_image/user.png";
        }
         if ($model->save()) {

                 return response()->json([
                'status' => true,
                'message' => 'profile updated successfully.',
                 ]);

          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid driverid.'
            ]);
          } 
    }
    
      public function findNearest($latitude, $longitude, $radius = 1000)
    {
        /*
         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
         * replace 6371000 with 6371 for kilometer and 3956 for miles
         */
          $restaurants = TravelRequest::selectRaw("travel_requests.id, users.name,users.l_name,users.mobile,users.email,users.user_image,users.gender,travel_requests.from_address,travel_requests.from_state,travel_requests.from_pincode, travel_requests.from_lat, travel_requests.from_long,travel_requests.distance,travel_requests.price,travel_requests.to_address,travel_requests.to_state,travel_requests.to_city,travel_requests.to_pincode,travel_requests.to_lat,travel_requests.to_long,
          ( 6371000 * acos( cos( radians(?) ) *
                           cos( radians( from_lat ) )
                           * cos( radians( from_long ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( from_lat ) ) )
                         ) AS distance", [$latitude, $longitude, $latitude])
            ->join('users','users.id','=','travel_requests.user_id')
            ->where('travel_requests.driver_id', NULL)
            ->where('travel_requests.status', 0)
            ->having("distance", "<", $radius)
            ->orderBy("distance",'asc')
            ->offset(0)
            ->limit(20)
            ->get();

        return $restaurants;
    }
    
    public function driverNearestUsers(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'driver_id'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $result = Driver::where('id',$request->driver_id)->first();
      
        if(empty($result)){
             return response()->json([
                'status' => false,
                'message' => 'invalid driverid.'
            ]);
        }
        
       $user = $this->findNearest($result->latitude,$result->longitude);
      
         if (count($user) > 0) {

                 return response()->json([
                'status' => true,
                'message' => 'users list',
                'data'=>$user
                 ]);

          }else{
            return response()->json([
                'status' => false,
                'message' => 'nearest trip not found.'
            ]);
          } 
    }
    public function acceptUserRide(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'driver_id'=>'required',
            'driver_latitude'=>'required',
            'driver_longitude'=>'required',
            'request_id'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $result = Driver::where('id',$request->driver_id)->first();
       
        if(empty($result) || $result === null){
             return response()->json([
                'status' => false,
                'message' => 'invalid driverid.'
            ]);
        }
        
        $restaurants = TravelRequest::where('id', $request->request_id)
        ->where('travel_requests.status', 0)
        ->where('driver_id', NULL)
        ->first();
      
         if (!empty($restaurants) || $restaurants != null) {
             
            $update = TravelRequest::where('id', $request->request_id)
            ->where('status', 0)
            ->where('driver_id', NULL)
            ->update(array('driver_id'=>$request->driver_id,'drv_accept_lat'=>$request->driver_latitude,'drv_accept_long'=>$request->driver_longitude,'status'=>1));
                if($update){
                            
                    $datass = TravelRequest::select('travel_requests.*','drivers.name as drivername','drivers.mobile','drivers.email','drivers.drv_image','drivers.vehicle_no','users.firbase_token','users.trip_otp')
                    ->leftjoin('drivers','drivers.id','=','travel_requests.driver_id')
                    ->leftjoin('users','users.id','=','travel_requests.user_id')
                    ->where('travel_requests.id',$request->request_id)->first();      
                    $latitude = 28.752041;  // Example latitude
                     $longitude = 77.2008786; // Example longitude
                     $radius = 3; // 3 kilometers
                   if(!empty($datass)){
                    $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
                    define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                     if($datass->firbase_token !=''){
                         
                     
                          $fcmMsg = array(
                                    'title' => "Driver accepted your booking ",
                                    'body' =>"Driver accepted your booking ",
                                    'sound' => 'noti_sound1.wav',
                                    'android_channel_id' => 'new_email_arrived_channel',
                                   
                                  );
                                  $fcmFields = array(
                                    'to' => $datass->firbase_token, //tokens sending for notification
                                    'notification' => $fcmMsg,
                                    'data'=>$datass,
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
                    
                    return response()->json([
                    'status' => true,
                    'message' => 'Trip accepted successfully.',
                    
                     ]);
      
                }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'You can`t accept this trip.'
                ]);  
                }
               
          }else{
            return response()->json([
                'status' => false,
                'message' => 'You can`t accept this trip or already accepted by other driver.'
            ]);
          } 
    }
    public function verify_trip_otp(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'request_id'=>'required',
            'driver_id'=>'required',
            'otp'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
       $result = Driver::where('id',$request->driver_id)->first();
       
        if(empty($result) || $result === null){
             return response()->json([
                'status' => false,
                'message' => 'invalid driverid.'
            ]);
        }
        
        $restaurants = TravelRequest::where('id', $request->request_id)
        ->where('travel_requests.status', 1)
        ->where('driver_id',$request->driver_id)
        ->first();
      
         if (!empty($restaurants) || $restaurants != null) {
            
            $userDes = User::where('id',$restaurants->user_id)->first();
            
             if($userDes->trip_otp !== (int)$request->otp){
                 return response()->json([
                'status' => false,
                'message' => 'Please enter valid OTP.'
                ]);
             }
             
            $update = TravelRequest::where('id', $request->request_id)
            ->where('status', 1)
            ->where('driver_id',$request->driver_id)
            ->update(array('trip_otp'=>$request->otp,'otp_verified'=>1,'status'=>2));
                if($update){
                
                    $driverUpdate = Driver::where('id',$request->driver_id)->update(array('strip_status'=>1));
                
                    $datass = TravelRequest::select('travel_requests.*','drivers.name as drivername','drivers.mobile','drivers.email','drivers.drv_image','drivers.vehicle_no','users.firbase_token','users.trip_otp')
                    ->leftjoin('drivers','drivers.id','=','travel_requests.driver_id')
                    ->leftjoin('users','users.id','=','travel_requests.user_id')
                    ->where('travel_requests.id',$request->request_id)->first();      
                    $latitude = 28.752041;  // Example latitude
                     $longitude = 77.2008786; // Example longitude
                     $radius = 3; // 3 kilometers
                   if(!empty($datass)){
                    $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
                    define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                     if($datass->firbase_token !=''){
                         
                     
                          $fcmMsg = array(
                                    'title' => "OTP verified successfully.Trip start now",
                                    'body' =>"OTP verified successfully.",
                                    'sound' => 'noti_sound1.wav',
                                    'android_channel_id' => 'new_email_arrived_channel',
                                   
                                  );
                                  $fcmFields = array(
                                    'to' => $datass->firbase_token, //tokens sending for notification
                                    'notification' => $fcmMsg,
                                    'data'=>$datass,
                                     'send_type'=>"verify_trip_otp",
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
                    
                    return response()->json([
                    'status' => true,
                    'message' => 'Trip start now.',
                    
                     ]);
      
                }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'something went wrong!'
                ]);  
                }
               
          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid details.'
            ]);
          } 
    }
    public function notifyUser(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'request_id'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $restaurants = TravelRequest::where('id', $request->request_id)
        ->where('status', 1)
        ->first();
      
         if (!empty($restaurants) || $restaurants != null) {
            
            $userDes = User::where('id',$restaurants->user_id)->first();
         
            $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
            
            define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                     
                     
                     if($userDes->firbase_token !=''){
                         
                     
                          $fcmMsg = array(
                                    'title' => "Dear ".$userDes->name.', driver reached at your pickup location ',
                                    'body' =>"Dear ".$userDes->name.', driver reached at your pickup location ',
                                    'sound' => 'noti_sound1.wav',
                                    'android_channel_id' => 'new_email_arrived_channel',
                                   
                                  );
                                  $fcmFields = array(
                                    'to' => $userDes->firbase_token, //tokens sending for notification
                                    'notification' => $fcmMsg,
                                    'data'=>$userDes,
                                     'send_type'=>"notifyUser",
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
                    
                    
                    return response()->json([
                    'status' => true,
                    'message' => 'user notified successfully.',
                    
                     ]);
               
          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid trip details.'
            ]);
          } 
    }
    public function getCurrentTrip(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'request_id'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $restaurants = TravelRequest::where('id', $request->request_id)
        ->where('travel_requests.status', 2)
        ->first();
      
         if (!empty($restaurants) || $restaurants != null) {
             
            $datass = TravelRequest::select('travel_requests.*','drivers.name as drivername','drivers.mobile','drivers.email','drivers.drv_image','drivers.vehicle_no','users.firbase_token','users.trip_otp')
                    ->leftjoin('drivers','drivers.id','=','travel_requests.driver_id')
                    ->leftjoin('users','users.id','=','travel_requests.user_id')
                    ->where('travel_requests.id',$request->request_id)
                    ->first();     
               if(!empty($datass)){
                   return response()->json([
                        'status' => true,
                        'message' => 'data found!',
                        'data'=>$datass
                    ]);
               }else{
                    return response()->json([
                'status' => false,
                'message' => 'data not found!'
            ]);
               }
          }else{
            return response()->json([
                'status' => false,
                'message' => 'data not found!'
            ]);
          } 
    }
    
    public function endTripFunction(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'request_id'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $restaurants = TravelRequest::where('id', $request->request_id)
        ->where('travel_requests.status', 2)
        ->first();
      
         if (!empty($restaurants) || $restaurants != null) {
            
            $userDes = User::where('id',$restaurants->user_id)->first();
            
            if($restaurants->trip_type == 'wallet'){
                
                if((int)$restaurants->price > (int)$userDes->wallet_amount){
                 return response()->json([
                    'status' => false,
                    'message' => 'Insufficient wallet amount,please recharge your wallet.'
                    ]);  
                }
            }
            
             
            $update = TravelRequest::where('id', $request->request_id)
            ->where('status', 2)
            ->where('driver_id',$request->driver_id)
            ->update(array('trip_end_time'=>time(),'status'=>3));
                if($update){
                    
                    $driverUpdate = Driver::where('id',$restaurants->driver_id)->update(array('strip_status'=>0));
                     
                    if($restaurants->trip_type == 'wallet'){
                        
                        $minuswallet = (int)$userDes->wallet_amount - (int)$restaurants->price;
                        $userDes = User::where('id',$restaurants->user_id)->update(array('wallet_amount'=>$minuswallet));
                    
                        
                    }
                   
                            
                    $datass = TravelRequest::select('travel_requests.*','drivers.name as drivername','drivers.mobile','drivers.email','drivers.drv_image','drivers.vehicle_no','users.firbase_token as userfirbase','users.trip_otp')
                    ->leftjoin('drivers','drivers.id','=','travel_requests.driver_id')
                    ->leftjoin('users','users.id','=','travel_requests.user_id')
                    ->where('travel_requests.id',$request->request_id)->first();      
                    $latitude = 28.752041;  // Example latitude
                     $longitude = 77.2008786; // Example longitude
                     $radius = 3; // 3 kilometers
                   if(!empty($datass)){
                    $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
                    define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                     if($datass->userfirbase !='' || $datass->userfirbase != NULL){
                         
                     
                          $fcmMsg = array(
                                    'title' => "Dear user your trip has been completed.",
                                    'body' =>"Dear user your trip has been completed.",
                                    'sound' => 'noti_sound1.wav',
                                    'android_channel_id' => 'new_email_arrived_channel',
                                   
                                  );
                                  $fcmFields = array(
                                    'to' => $datass->userfirbase, //tokens sending for notification
                                    'notification' => $fcmMsg,
                                    'data'=>$datass,
                                     'send_type'=>"end_trip",
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
                    
                    return response()->json([
                    'status' => true,
                    'message' => 'Trip completed.',
                    
                     ]);
      
                }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'something went wrong!'
                    ]);  
                }
               
          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid details.'
            ]);
          } 
    }
    
    
    public function cancelTravelRequestDriv(Request $request){
       
        // $userid = Auth::user()->id;
     
        $validator = Validator::make($request->all(), [
             'trip_id' => 'required',
             'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $data = TravelRequest::where('driver_id',$request->driver_id)->where('id',$request->trip_id)->first();
             
          if(!empty($data)){
            $result="";
            $model = TravelRequest::find($request->trip_id);
            $model->status = 4;
            $model->cancel_desc = 'Driver';
              
              if($model->save()){
                  
                 $userData = User::select('firbase_token','name')->where('id',$data->user_id)->first();
                   
               
                  if(!empty($userData)){
                    $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
                    define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                     if($userData->firbase_token !='' || $userData->firbase_token != NULL){
                         
                     
                          $fcmMsg = array(
                                    'title' => "Dear user your trip has been canceled.",
                                    'body' =>"Dear user your trip has been canceled.",
                                    'sound' => 'noti_sound1.wav',
                                    'android_channel_id' => 'new_email_arrived_channel',
                                   
                                  );
                                  $fcmFields = array(
                                    'to' => $userData->firbase_token, //tokens sending for notification
                                    'notification' => $fcmMsg,
                                    'data'=>$userData,
                                     'send_type'=>"end_trip",
                                    'notification_type'=>'Driver',
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
                  
                  
                return response()->json([
                'status' => true,
                'message' => 'trip canceled successfully.',
                ]);      
              }else{
                   return response()->json([
                'status' => false,
                'message' => 'something went wrong!'
                 ]);
              }
              
          }else{
            return response()->json([
                'status' => false,
                'message' => 'trip not found!'
            ]);
          }
    }
    
    public function getpackageList(Request $request){
      
        $result = DB::table('packages')->where('status',1)->orderBy('amount','ASC')->get();
        if(count($result) > 0){
             return response()->json([
                'status' => true,
                'message' => 'package list',
                'data'=>$result
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'data not found.',
                 'accept'=>false,
            ]);
          } 
       
    }
    
    public function getActiveTripDiver(Request $request){
       
        // $userid = Auth::user()->id;
     
        $validator = Validator::make($request->all(), [
             'driver_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $data = TravelRequest::select('travel_requests.*','usr.name as username','usr.mobile as usermobile','usr.user_image')->leftjoin('users as usr','usr.id','=','travel_requests.user_id')->where('travel_requests.driver_id',$request->driver_id)->whereIn('travel_requests.status',[1,2])->orderBy('travel_requests.id','DESC')->first();
             
        if(!empty($data)){
              
             return response()->json([
                'status' => true,
                'message' => 'active trip details',
                'data'=>$data
                 ]);
              
        }else{
            return response()->json([
                'status' => false,
                'message' => 'trip not found!'
            ]);
        }
    }

}
