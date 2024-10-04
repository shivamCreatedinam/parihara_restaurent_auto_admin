<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Driver;
use App\Models\AddressBook;
use App\Models\Order;
use App\Models\TravelRequest;
use Auth;
use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Parihara Api Documentation",
 *      description="This is a sample API documentation using Swagger in Laravel",
 *      @OA\Contact(
 *          email="your-email@example.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */



    public function sendotp(Request $request)
    {
        echo 'hello';
        
        $receiverNumber = "+919506704563";
        $message = "2645 is your login OTP. It is valid for next 5 minutes, do not share your OTP with anyone.Thanks for visiting Parihara.";
  
        try {
  
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_NUMBER");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
            echo 'SMS Sent Successfully.';
  
        } catch (Exception $e) {
          echo $e->getMessage();
        }
    }

    /**
 * @OA\Post(
 *     path="/api/register",
 *     summary="User Registration with OTP verification",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"mobile", "otp"},
 *             @OA\Property(property="mobile", type="string", example="9876543210", description="User's mobile number"),
 *             @OA\Property(property="otp", type="string", example="1234", description="OTP received by the user")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successfully logged in or registered",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="successfully logged in."),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="is_update", type="boolean", example=true),
 *             @OA\Property(property="token", type="string", example="your_access_token")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid OTP",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="You entered wrong otp.")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object", 
 *                 @OA\Property(property="mobile", type="array", @OA\Items(type="string", example="The mobile must be 10 digits.")),
 *                 @OA\Property(property="otp", type="array", @OA\Items(type="string", example="The otp must be 4 digits."))
 *             )
 *         ),
 *     )
 * )
 */


    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('mobile','otp');
        $validator = Validator::make($data, [
            'mobile' => 'required|min:10|max:10',
            'otp' => 'required|min:4|max:4',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
          $otp=DB::table('otp_verification')  
            ->where(['mobile'=>$request->mobile])
            ->where(['otp'=>$request->otp])
            ->first(); 
            
            if(empty($otp) || $otp ==null){
                 return response()->json([
                    'status' => false,
                    'message' => 'You entered wrong otp.',
                ]);
            }
        
           $result=DB::table('users')  
            ->where(['mobile'=>$request->mobile])
            ->first();  
          
       
        if(!empty($result)){
           
           
            if (Auth::loginUsingId($result->id) && $result->id > 0) {
                $user  = Auth::user();
                $token = $user->createToken('Parihara')->plainTextToken;
    
                // if($request->firbase_token !=''){
                //     $upd=DB::table('users')  
                //     ->where('id',$user->id)
                //     ->update(['firbase_token'=>$request->firbase_token]); 
                //     }
                $delete=DB::table('otp_verification')  
                ->where(['mobile'=>$request->mobile])
                ->delete(); 
                
                return response()->json([
                    'status' => true,
                    'message' => 'successfully logged in.',
                    'name'=>$user->name,
                    'id'=>$user->id,
                     'is_update'=>$result->is_update,
                    'token'=>$token,
                    
                ]);
            }
           
        }else{
            $getid = DB::table('users')->orderBy('id','DESC')->first();
          
            if(!empty($getid)){
                $maxid = $getid->id;        
            }else{
                $maxid = 1;
            }
            $u = $maxid+1;
            $UID = "USR0".$u; 
        $otptralv = rand(1000,9999);
        $model = new User();
        $model->user_id = $UID;
        $model->user_type = "USER";
        $model->trip_otp =$otptralv;
        $model->name = NULL;
        $model->email = NULL;
        $model->password = NULL;
        $model->mobile =$request->mobile;
        $model->firbase_token =NULL;
        $model->gender =NULL;
        $model->user_activate =1;
        $model->user_image="uploads/user_image/user.png";
        $model->created_date=my_date();
        $model->created_time=my_time();
        $model->status ="1";

        //User created, return success response
           if ($model->save()) {
            $token = $model->createToken('Parihara')->plainTextToken;
            
            $delete=DB::table('otp_verification')  
            ->where(['mobile'=>$request->mobile])
            ->delete(); 
            $res=DB::table('users')  
            ->where(['id'=>$model->id])
            ->first(); 
            
            
            return response()->json([
            'status' => true,
            'name' => $model->name,
            'message' => 'User created successfully',
            'token' => $token,
            'id'=>$model->id,
            'is_update'=>$res->is_update,
                ]);
           }else{
            return response()->json([
            'status' => false,
            'message' => 'Something wrong !',
            ]);
           }
        
        }
        
    }

    /**
 * @OA\Post(
 *     path="/api/requesting_for_otp",
 *     tags={"OTP"},
 *     summary="Request an OTP",
 *     description="Send OTP to the user's mobile number for verification",
 *     operationId="requesting_for_otp",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User mobile number",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="mobile",
 *                 type="string",
 *                 description="Mobile number of the user",
 *                 example="9876**3210"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OTP sent successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Otp sent successfully.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request, validation errors",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Validation error message")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Error message")
 *         )
 *     )
 * )
 */


    public function requesting_for_otp(Request $request)
    {
        $credentials = $request->only('mobile');
         $mobile = $request->input('mobile');
        //valid credential
        $validator = Validator::make($credentials, [
            'mobile' => 'required|min:10|max:10',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
       
          $result=DB::table('users')  
            ->orWhere(['mobile'=>$request->mobile])
            ->first(); 
            
        $otp = rand(1000,9999);
        $db = DB::table('otp_verification')->where('mobile',$request->mobile)->delete();
      
        $receiverNumber = "+91".$request->mobile;
        $message = "Your verification Code From Parihara is ".$otp.". Your request id is 4kyu+H1QA86";
  
        try {
  
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_NUMBER");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
                $insert = DB::table('otp_verification')->insert(array(
                    'mobile'=>$request->mobile,
                    'otp'=>$otp,
                    'created_at'=>date('Y-m-d H:i:s'),
                    ));
                
                return response()->json([
                    'status' => true,
                    'message' => 'Otp sent successfully.',
                    
                ]);
  
        } catch (Exception $e) {
         
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
      
    }
    
    /**
 * @OA\Post(
 *     path="/api/forgot-password",
 *     summary="Update password using OTP",
 *     description="Updates the user's password after verifying the OTP sent to their mobile.",
 *     operationId="otpUpdatePassword",
 *     tags={"Forget pwd"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="mobile", type="string", example="+919123456789"),
 *             @OA\Property(property="otp", type="string", example="1234"),
 *             @OA\Property(property="new_password", type="string", example="NewPassword123"),
 *             @OA\Property(property="confirm_password", type="string", example="NewPassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Password changed successfully.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                 @OA\Property(property="mobile", type="array", @OA\Items(type="string", example="The mobile field is required.")),
 *                 @OA\Property(property="otp", type="array", @OA\Items(type="string", example="The otp field is required.")),
 *                 @OA\Property(property="new_password", type="array", @OA\Items(type="string", example="The new password field is required.")),
 *                 @OA\Property(property="confirm_password", type="array", @OA\Items(type="string", example="The confirm password field is required."))
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid OTP",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="You entered wrong otp.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Password mismatch",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Confirm password not matching.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Please enter registered mobile number.")
 *         )
 *     )
 * )
 */


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
        
          
       
          $result=DB::table('users')  
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
               $updt1 = DB::table('users')
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

    /**
 * @OA\Post(
 *     path="/api/change-password",
 *     summary="Update user password",
 *     description="Updates the user's password for a registered mobile number.",
 *     operationId="updatePassword",
 *     tags={"Update Pwd"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="mobile", type="string", example="+919123456789"),
 *             @OA\Property(property="new_password", type="string", example="NewPassword123"),
 *             @OA\Property(property="confirm_password", type="string", example="NewPassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Password changed successfully.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                 @OA\Property(property="mobile", type="array", @OA\Items(type="string", example="The mobile field is required.")),
 *                 @OA\Property(property="new_password", type="array", @OA\Items(type="string", example="The new password field is required.")),
 *                 @OA\Property(property="confirm_password", type="array", @OA\Items(type="string", example="The confirm password field is required."))
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Password mismatch",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Confirm password not matching.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Please enter registered mobile number.")
 *         )
 *     )
 * )
 */

    public function update_password(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10|max:10',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
       
          $result=DB::table('users')  
            ->orWhere(['mobile'=>$request->mobile])
            ->first(); 
       
        if(!empty($result)){

            if ($request->new_password != $request->confirm_password) {
                return response()->json([
                    'status' => false,
                    'message' => 'Confirm password not matching.',
                ]);
            }

            $update = array(
                'password'=>bcrypt($request->new_password),
              );
               $updt1 = DB::table('users')
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

    /**
 * @OA\Post(
 *     path="/api/driver-login",
 *     summary="Driver authentication",
 *     description="Authenticates a user using email or mobile and password.",
 *     operationId="authenticateUser",
 *     tags={"Driver Login"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password123"),
 *             @OA\Property(property="firbase_token", type="string", example="firebase_token_here")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Authentication successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="successfully logged in."),
 *             @OA\Property(property="user", type="string", example="User Name"),
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="token", type="string", example="generated_token_here")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="The email field is required.")),
 *                 @OA\Property(property="password", type="array", @OA\Items(type="string", example="The password field is required."))
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Invalid credentials.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Invalid Password",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Invalid Password.")
 *         )
 *     )
 * )
 */
    public function authenticate(Request $request)
    {
       $email = $request->email;
       $password = $request->password;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|string|min:6|max:20'
                 ]);
        } else {
                $validator = Validator::make($request->all(), [
                'email' => 'required',
                 ]);
        }
          //     //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $field = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $request->merge([$field => $email]);
         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $resuser =  User::where('email',$request->email)->first();
        } else {
               $resuser =  User::where('mobile',$request->email)->first();
        }
       
       if(!empty($resuser)){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
             if(!Hash::check($password, $resuser->password)){
                return response()->json([
                     'status' => false,
                     'message' => 'Invalid Password.',
                 ]); 
             }
            }
        $id = $resuser->id;
       }else{
             return response()->json([
                     'status' => false,
                     'message' => 'Invalid credentials.',
                 ]);
                 
        $id = 0;
       }
        $token = null;
         $checks =  "";
        if (Auth::loginUsingId($id) && $id > 0) {
            $user  = Auth::user();
            $token = $user->createToken('Anandfood')->plainTextToken;

            if($request->firbase_token !=''){
                $upd=DB::table('users')  
                ->where('id',$user->id)
                ->update(['firbase_token'=>$request->firbase_token]); 
                }

            return response()->json([
                'status' => true,
                'message' => 'successfully logged in.',
                'user'=>$user->name,
                'id'=>$user->id,
                'token'=>$token,
            ]);
        }else{
            return response()->json([
                     'status' => false,
                     'message' => 'Invalid credentials.',
                 ]);
         }
        
    }

    /**
 * @OA\Post(
 *     path="/api/logout",
 *     summary="User logout",
 *     description="Logs out the authenticated user by deleting the current access token.",
 *     operationId="logoutUser",
 *     tags={"Authentication"},
 *     @OA\Response(
 *         response=200,
 *         description="Logged out successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Logged out successfully.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Logout failed",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Logout failed. Please try again."),
 *             @OA\Property(property="error", type="string", example="Error details here (optional).")
 *         )
 *     )
 * )
 */
    public function logout(Request $request)
    {
        try {
            // Delete the current access token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Logout failed. Please try again.',
                'error' => $e->getMessage(), // Optionally include error details for debugging
            ], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/my-profile",
 *     summary="Get user profile",
 *     description="Retrieves the authenticated user's profile information.",
 *     operationId="getUserProfile",
 *     tags={"Proile"},
 *     @OA\Response(
 *         response=200,
 *         description="User profile retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="My profile"),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="mobile", type="string", example="+919123456789"),
 *                 @OA\Property(property="user_image", type="string", example="uploads/user_image/male.png"),
 *                 @OA\Property(property="gender", type="string", example="Male"),
 *                 @OA\Property(property="wallet_amount", type="number", format="float", example=100.50),
 *                 @OA\Property(property="trip_otp", type="string", example="1234")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="invalid user")
 *         )
 *     )
 * )
 */
    public function get_user(Request $request)
    {
       
        $userid = Auth::user()->id;
          $result =  User::where(['id'=>$userid])->select('id','name','email','mobile','user_image','gender','wallet_amount','trip_otp')->first();
          if ($result->gender == 'Male') {
            $result->user_image = "uploads/user_image/male.png";
          }
          if ($result->gender == 'Female') {
            $result->user_image = "uploads/user_image/female.png";
          }
          
          if(!empty($result)){
            return response()->json([
                'status' => true,
                'message' => 'My profile',
                'user'=>$result
            ]);
          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid user'
            ]);
          }
    }

    /**
 * @OA\Get(
 *     path="/api/my-wallet",
 *     summary="Get user wallet information",
 *     description="Retrieves the authenticated user's wallet information.",
 *     operationId="getUserWallet",
 *     tags={"user wallet"},
 *     @OA\Response(
 *         response=200,
 *         description="User wallet information retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="My wallet"),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="wallet_amount", type="number", format="float", example=150.75)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="invalid user")
 *         )
 *     )
 * )
 */
    public function get_user_wallet(Request $request)
    {
        $userid = Auth::user()->id;
          $result =  User::select('id','name','wallet_amount')->where(['id'=>$userid])->first();
      
          if(!empty($result)){
            return response()->json([
                'status' => true,
                'message' => 'My wallet',
                'user'=>$result
            ]);
          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid user'
            ]);
          }
    }

    /**
 * @OA\Get(
 *     path="/api/my-wallet-transaction",
 *     summary="Get user wallet recharge transactions",
 *     description="Retrieves the authenticated user's wallet recharge transactions.",
 *     operationId="getUserWalletRechargeTransactions",
 *     tags={"Wallet Transactions"},
 *     @OA\Response(
 *         response=200,
 *         description="User wallet recharge transactions retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="My wallet transaction"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="amount", type="number", format="float", example=100.50),
 *                     @OA\Property(property="status", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-04T12:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-10-04T12:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No transactions found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="data not found!")
 *         )
 *     )
 * )
 */

    public function getUserWalletRechargeTransaction(Request $request)
    {
       
         $userid = Auth::user()->id;
          $result =  Order::where(['user_id'=>$userid])->where('status',1)->orderBy('id','DESC')->get();
        
          if(count($result) > 0){
            return response()->json([
                'status' => true,
                'message' => 'My wallet transaction',
                'data'=>$result
            ]);
          }else{
            return response()->json([
                'status' => false,
                'message' => 'data not found!'
            ]);
          }
    }
    
    /**
 * @OA\Get(
 *     path="/api/get-location-history",
 *     summary="Get user location search history",
 *     description="Retrieves the authenticated user's location search history.",
 *     operationId="getLocationSearchHistory",
 *     tags={"Location History"},
 *     @OA\Response(
 *         response=200,
 *         description="User location search history retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="My search history"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="search_query", type="string", example="New York"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-04T12:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-10-04T12:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No search history found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="data not found!")
 *         )
 *     )
 * )
 */

    public function getLocationSearchHistory(Request $request)
    {
       
         $userid = Auth::user()->id;
        $result = DB::table('travel_search_history')
        ->where('user_id',$userid)
        ->orderBy('id','DESC')
         ->get();  
        
          if(count($result) > 0){
            return response()->json([
                'status' => true,
                'message' => 'My search history',
                'data'=>$result
            ]);
          }else{
            return response()->json([
                'status' => false,
                'message' => 'data not found!'
            ]);
          }
    }
    
    
     public function findNearestRestaurants($latitude, $longitude, $radius = 2000)
    {
        /*
         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
         * replace 6371000 with 6371 for kilometer and 3956 for miles
         */
         $radius1 = 3000;
        $restaurants = Driver::selectRaw("id, name, address, latitude, longitude,firbase_token,
                         ( 6371000 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance", [$latitude, $longitude, $latitude])
            ->where('status', '=', 1)
            ->where('duty_status', '=', 'On')
            ->where('strip_status', '=', 0)
            ->having("distance", "<", $radius1)
            ->orderBy("distance",'asc')
            ->offset(0)
            ->limit(30)
            ->get();

        return $restaurants;
    }

    
     public function travelRequest(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'distance' => 'required',
            'trip_type' => 'required',
            'from_address' => 'required',
            'from_state' => 'required',
            'from_city' => 'required',
            'from_pincode' => 'required',
            'from_lat' => 'required',
            'from_long' => 'required',
            'distance' => 'required',
            'price' => 'required',
            'to_address' => 'required',
            'to_state' => 'required',
            'to_city' => 'required',
            'to_pincode' => 'required',
            'to_lat' => 'required',
            'to_long' => 'required',
        ]);

        // //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $userid = Auth::user()->id;
        $result =  User::select('id','wallet_amount')->where(['id'=>$userid])->first();
          if(empty($result)){
               return response()->json([
                'status' => false,
                'message' => 'unauthorized user!'
            ]);
          }
          
          if($request->trip_type == 'wallet'){
            
            if((int)$request->price  > (int)$result->wallet_amount){
                return response()->json([
                'status' => false,
                'message' => 'Insufficient wallet balance, please recharge your wallet!'
                ]);
            }  
          }
          
          if ($request->promocode != '') {
                $request->amount = $request->price;
                $couponresponse = $this->apply_promocode($request);
              
               $CopnRes = json_encode($couponresponse);
                $CopnResDec = json_decode($CopnRes);
               
               if ($CopnResDec->original->status==false) {
                 return $couponresponse;
               }else{
                 $grandtotal = $CopnResDec->original->after_discounted_cart_amount;
                 $discountvalue = $CopnResDec->original->discounted_value;
                 $applied_coupon_code = $request->promocode;
               }
               
            }else{
                 $grandtotal = $request->price;
                 $discountvalue = "0";
                 $applied_coupon_code="";
       
            }
         
          
             $model =  new TravelRequest();
             $model->from_address = $request->from_address;
             $model->trip_type = $request->trip_type;
             $model->from_state = $request->from_state;
             $model->from_city = $request->from_city;
             $model->from_pincode = $request->from_pincode;
             $model->from_lat = $request->from_lat;
             $model->from_long = $request->from_long;
             $model->distance = $request->distance;
             $model->discount_amount = $discountvalue;
             $model->applied_coupon = $applied_coupon_code;
             $model->price = $request->price;
             $model->to_address = $request->to_address;
             $model->to_state = $request->to_state;
             $model->to_city = $request->to_city;
             $model->to_pincode = $request->to_pincode;
             $model->to_lat = $request->to_lat;
             $model->to_long = $request->to_long;
             $model->created_date = date('Y-m-d H:i:s');
             $model->status =0;
             $model->user_id =$userid;
             
          if($model->save()){
         $datass = TravelRequest::where('id',$model->id)->where('user_id',$userid)->first();  
         
           $travelTransData = array(
                'user_id'=>$userid,
                'trip_type'=>$request->trip_type,
                'from_address'=>$request->from_address,
                'from_state'=>$request->from_state,
                'from_city'=>$request->from_city,
                'from_pincode'=>$request->from_pincode,
                'from_lat'=>$request->from_lat,
                'from_long'=>$request->from_long,
                'distance'=>$request->distance,
                'to_address'=>$request->to_address,
                'to_state'=>$request->to_state,
                'to_city'=>$request->to_city,
                'to_pincode'=>$request->to_pincode,
                'to_lat'=>$request->to_lat,
                'to_long'=>$request->to_long,
                'status'=>1,
                'created_date'=>date('Y-m-d H:i:s'),
            );
         
         $checkcount = DB::table('travel_search_history')
         ->where('from_address',$request->from_address)
         ->where('trip_type',$request->trip_type)
         ->where('from_state',$request->from_state)
         ->where('from_city',$request->from_city)
         ->where('to_address',$request->to_address)
         ->where('to_state',$request->to_state)
         ->where('to_city',$request->to_city)
         ->where('user_id',$userid)
         ->count();  
         if($checkcount == 0){
             $checkcount = DB::table('travel_search_history')->insert($travelTransData);  
         }
       
         $trAxData = array(
            'id'=>$datass->id,
                'user_id'=>$datass->user_id,
                'trip_type'=>$datass->trip_type,
                'driver_id'=>$datass->driver_id,
                'from_address'=>$datass->from_address,
                'from_state'=>$datass->from_state,
                'from_city'=>$datass->from_city,
                'from_pincode'=>$datass->from_pincode,
                'from_lat'=>$datass->from_lat,
                'from_long'=>$datass->from_long,
                'distance'=>$datass->distance,
                'price'=>$datass->price,
                'to_address'=>$datass->to_address,
                'to_state'=>$datass->to_state,
                'to_city'=>$datass->to_city,
                'to_pincode'=>$datass->to_pincode,
                'to_lat'=>$datass->to_lat,
                'to_long'=>$datass->to_long,
                'drv_accept_lat'=>$datass->drv_accept_lat,
                'drv_accept_long'=>$datass->drv_accept_long,
                'status'=>$datass->status,

            );
       
        
        $latitude = 28.752041;  // Example latitude
         $longitude = 77.2008786; // Example longitude
         $radius = 2000; // 3 kilometers
       
        $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
        $dd = $this->findNearestRestaurants($request->from_lat, $request->from_long);

        define( 'API_ACCESS_KEY', $SERVER_API_KEY );
        foreach($dd as $dds){
         if($dds->firbase_token !=''){
             
         
              $fcmMsg = array(
                        'title' => "You have recieved a new Trip ",
                        'body' =>"From -  ".$request->from_address." To -".$request->to_address,
                        'sound' => 'noti_sound1.wav',
                        'android_channel_id' => 'new_email_arrived_channel',
                        
                      );
                      $fcmFields = array(
                        'to' => $dds->firbase_token, //tokens sending for notification
                        'notification' => $fcmMsg,
                        'data'=>$trAxData,
                        'send_type'=>"Travel_Request",
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
                'message' => 'request added successfully.',
                'id'=>$model->id,
                'data'=>$datass
            ]);
          }else{
            return response()->json([
                'status' => false,
                'message' => 'something went wrong!'
            ]);
          }
    }
    
    /**
 * @OA\Get(
 *     path="/api/user-trip-list",
 *     summary="Get user travel request list",
 *     description="Retrieves the authenticated user's travel requests.",
 *     operationId="travelRequestList",
 *     tags={"User"},
 *     @OA\Response(
 *         response=200,
 *         description="Travel request list retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="My trip list."),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="status", type="integer", example=1),
 *                     @OA\Property(property="trip_details", type="string", example="Trip to New York"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-04T12:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-10-04T12:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No travel requests found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="No trip requests found.")
 *         )
 *     )
 * )
 */

    public function travelRequestList(Request $request)
    {
        $userid = Auth::user()->id;

        $data = TravelRequest::where('user_id', $userid)
            ->whereIn('status', [1, 2, 3, 4])
            ->orderBy('id', 'DESC')
            ->get();

        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'My trip list.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No trip requests found.'
            ]);
        }
    }

    
    public function cancelTravelRequest(Request $request){
       
        $userid = Auth::user()->id;
     
        $validator = Validator::make($request->all(), [
             'trip_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $data = TravelRequest::where('user_id',$userid)->where('id',$request->trip_id)->first();
             
          if(!empty($data)){
            
            $model = TravelRequest::find($request->trip_id);
            $model->status = 4;
            $model->cancel_desc = 'User';
              
              if($model->save()){
                  
                  
                   $userData = Driver::select('firbase_token','name')->where('id',$data->driver_id)->first();
                   
               
                  if(!empty($userData)){
                    $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
                    define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                     if($userData->firbase_token !='' || $userData->firbase_token != NULL){
                         
                     
                          $fcmMsg = array(
                                    'title' => "Dear driver your trip has been canceled by user.",
                                    'body' =>"Dear driver your trip has been canceled by user.",
                                    'sound' => 'noti_sound1.wav',
                                    'android_channel_id' => 'new_email_arrived_channel',
                                   
                                  );
                                  $fcmFields = array(
                                    'to' => $userData->firbase_token, //tokens sending for notification
                                    'notification' => $fcmMsg,
                                    'data'=>$userData,
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

    public function update_profile(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required',
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
                $userid = Auth::user()->id;
         
                $model = User::find($userid);
                $model->name = $request->name;
                $model->email = $request->email;
                $model->mobile = $request->mobile;
                $model->gender = $request->gender;
                $model->is_update = '1';
                if($model->save()){
                return response()->json([
                'status' => true,
                'message' => 'profile updated successfully.',
                 ]);    
                }else{
                return response()->json([
                'status' => true,
                'message' => 'profile updated successfully.',
                 ]);
                }

                

         
    }
    public function updateFcmToken(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'token'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $userid = Auth::user()->id;
         if (user_exist($userid)) {
                $model = User::find($userid);
                $model->firbase_token = $request->token;
                $model->save();

                 return response()->json([
                'status' => true,
                'message' => 'token updated successfully.',
                 ]);

          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid user'
            ]);
          } 
    }


    public function add_address(Request $request)
    {
    	//Validate data
       
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'full_name' => 'required',
            'mobile' => 'required|min:10|max:10',
            'house_no' => 'required',
            'appartment'=>'required',
            'city'=>'required',
            'state'=>'required',
            'pincode'=>'required',
            'address_type'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        if (user_exist($request->user_id)) {
            $model = new AddressBook();
           
            $model->user_id = $request->user_id;
            $model->full_name =$request->full_name;
            $model->mobile =$request->mobile;
            $model->house_no =$request->house_no;
            $model->appartment =$request->appartment;
            $model->city =$request->city;
            $model->state =$request->state;
            $model->pincode =$request->pincode;
            $model->address_type =$request->address_type;
            $model->latitude =$request->latitude;
            $model->longitude =$request->longitude;
            $model->created_date=my_date();
            $model->status ="1";
    
            //User created, return success response
               if ($model->save()) {
                return response()->json([
                'status' => true,
                'message' => 'Address added successfully',
                    ]);
               }else{
                return response()->json([
                'status' => false,
                'message' => 'Something wrong !',
                ]);
               }
            
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid User.'
              ]);
        }
    
    }



    public function update_address(Request $request)
    {
    	//Validate data
       
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
            'user_id' => 'required',
            'full_name' => 'required',
            'mobile' => 'required|min:10|max:10',
            'house_no' => 'required',
            'appartment'=>'required',
            'city'=>'required',
            'state'=>'required',
            'pincode'=>'required',
            'address_type'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        if (user_exist($request->user_id)) {
            
            $model =  AddressBook::find($request->address_id);
            $model->user_id = $request->user_id;
            $model->full_name =$request->full_name;
            $model->mobile =$request->mobile;
            $model->house_no =$request->house_no;
            $model->appartment =$request->appartment;
            $model->city =$request->city;
            $model->state =$request->state;
            $model->pincode =$request->pincode;
            $model->address_type =$request->address_type;
            $model->latitude =$request->latitude;
            $model->longitude =$request->longitude;
            $model->status ="1";
    
            //User created, return success response
               if ($model->save()) {
                return response()->json([
                'status' => true,
                'message' => 'Address updated successfully.',
                    ]);
               }else{
                return response()->json([
                'status' => false,
                'message' => 'Something wrong !',
                ]);
               }
            
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid User.'
              ]);
        }
    
    }


    public function address_details(Request $request)
    {
    	//Validate data
       
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
            'user_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        if (user_exist($request->user_id)) {
            
            $model =  AddressBook::where('id',$request->address_id)->where('status',1)->where('user_id',$request->user_id)->first();

            //User created, return success response
               if (!empty($model)) {
                return response()->json([
                'status' => true,
                'message' => 'Address details',
                'data'=>$model,
                    ]);
               }else{
                return response()->json([
                'status' => false,
                'message' => 'Data not found!',
                ]);
               }
            
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid User.'
              ]);
        }
    
    }


    public function address_list(Request $request)
    {
    	//Validate data
       
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        if (user_exist($request->user_id)) {
            
            $model =  AddressBook::where('status',1)->where('user_id',$request->user_id)->orderBy('id','DESC')->get();

            //User created, return success response
               if (count($model) > 0) {
                return response()->json([
                'status' => true,
                'message' => 'Address list',
                'data'=>$model,
                    ]);
               }else{
                return response()->json([
                'status' => false,
                'message' => 'Data not found!',
                ]);
               }
            
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid User.'
              ]);
        }
    
    }


    public function delete_address(Request $request)
    {
    	//Validate data
       
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
            'user_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        if (user_exist($request->user_id)) {
            
            $model =  AddressBook::find($request->address_id);
            $model->status ="5";
    
            //User created, return success response
               if ($model->save()) {
                return response()->json([
                'status' => true,
                'message' => 'Address deleted successfully.',
                    ]);
               }else{
                return response()->json([
                'status' => false,
                'message' => 'Something wrong !',
                ]);
               }
            
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid User.'
              ]);
        }
    
    }
    
     public function update_profile_image(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'image'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $userid = Auth::user()->id;
        $count = User::where('id',$userid)->count();
        if($count == 0){
             return response()->json([
                'status' => false,
                'message' => 'invalid userid.'
            ]);
        }
        
        $model = User::find($userid);
          if($request->hasfile('image')){
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
           
            $image->move(public_path('uploads/user_image'), $image_name);
            $model->user_image = "uploads/user_image/".$image_name;
        }else{
            $model->user_image = "uploads/user_image/user.png";
        }
         if ($model->save()) {

                 return response()->json([
                'status' => true,
                'message' => 'profile updated successfully.',
                 ]);

          }else{
            return response()->json([
                'status' => false,
                'message' => 'invalid userid.'
            ]);
          } 
    }
    
    
    
    public function getTripDriver(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'travel_req_id'=>'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $userid = Auth::user()->id;
        $result = TravelRequest::where('user_id',$userid)->where('id',$request->travel_req_id)->where('driver_id','!=',NULL)->where('status',1)->first();
        if(empty($result)){
             return response()->json([
                'status' => false,
                'message' => 'Driver not accepted',
                'accept'=>false
            ]);
        }
        $driverRes = Driver::where('id',$result->driver_id)->where('status',1)->first();
        $result->driver_details = $driverRes;
         if (!empty($driverRes)) {

                 return response()->json([
                'status' => true,
                'message' => 'Trip Details',
                'data'=>$result,
                'accept'=>true,
                 ]);

          }else{
            return response()->json([
                'status' => false,
                'message' => 'details not found.',
                 'accept'=>false,
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
    
    public function getCurrentTripUser(Request $request){
       
         $userid = Auth::user()->id;
        
        $data = TravelRequest::select('travel_requests.*','drv.name as drivername','drv.mobile as drivermobile','drv.drv_image','drv.vehicle_no')->leftjoin('drivers as drv','drv.id','=','travel_requests.driver_id')->where('travel_requests.user_id',$userid)->whereIn('travel_requests.status',[1,2])->orderBy('travel_requests.id','DESC')->first();
             
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
