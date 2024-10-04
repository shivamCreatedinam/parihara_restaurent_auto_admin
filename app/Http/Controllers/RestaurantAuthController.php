<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\TravelRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RestaurantAuthController extends Controller
{
     public function index()
    {
        
       return view('restaurant/login');
    }
     public function auth(Request $request)
    {
      $email = $request->post('email');
      $password = $request->post('password');

       $result = Restaurant::where(['email'=>$email])->first();
      
      if(!empty($result)){
         if(Hash::check($password,$result->password)){
            $request->session()->put('REST_LOGIN',true);
            $request->session()->put('REST_ID',$result->id);
            $request->session()->put('REST_USERID',$result->restaurant_id);
            $request->session()->put('REST',$result->restaurant_name);
            $request->session()->put('RESTEMAIL',$result->email);
            return redirect('restaurant/dashboard');
         }else{
            $request->session()->flash('error','Please enter correct password.');
            return redirect('sysadmin');
         }
        
      }else{
         $request->session()->flash('error','Please enter valid Email ID');
         return redirect('restaurant/login');
      }
    }
    
     public function dashboard(Request $request)
    {
        $data['users'] = User::whereIn('user_type',['USER','SUBADMIN'])->count();
        $data['stock_product'] = Product::where('qty','!=','0')->where('status','!=','5')->count();
        $data['out_of_stock_product'] = Product::where('qty','=','0')->where('status','!=','5')->count();
        $data['categories'] = Category::where('status','!=','5')->count();

        $data['total_order'] = Order::where('status','1')->count();
        $data['processing_order'] = Order::where('status','1')->whereIn('order_status',['Processing'])->count();
        $data['complete_order'] = Order::where('status','1')->whereIn('order_status',['Delivered'])->count();
        $data['return_order'] = Order::where('status','1')->whereIn('order_status',['Returned'])->count();
        $data['earning_order'] = Order::where('status','1')->whereIn('order_status',['Delivered'])->sum('grand_total');

        $data['recent_order'] = Order::where('status','1')->orderBy('id','DESC')->take(20)->get();
       

        $prodid = array();
        $order = DB::table('order_products')
                ->select('product_id', DB::raw('COUNT(product_id) as total_prod'))
                ->groupBy('product_id')
                ->orderBy('total_prod','DESC')
                ->take(5)
                ->get();
        foreach ($order as $value) {
            $prodid[] = $value->product_id;
        }   
       $implode = implode(',',$prodid);

        $data['best_order'] = DB::table('products')->select('products.*','product_attributes.attribute_title')
        ->leftJoin('product_attributes','product_attributes.id','=','products.attribute_id')
        ->whereIn('products.id',[$implode])->where('products.status','1')->get();

        $data['recent_users'] = User::whereIn('user_type',['USER'])->orderBy('id','DESC')->take(10)->get();
       
       return view('restaurant/dashboard',$data);
    }
    public function my_profile(Request $request)
    {
        $data['data'] = Restaurant::where('id',$request->session()->get('REST_ID'))->first();
        
        return view('restaurant/my_profile',$data);
    }
    
     public function change_password(Request $request)
    {
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required', 
            'new_confirm_password'=>'required',  
        ]);
        
        if($request->post('new_password') != $request->post('new_confirm_password')){

            $request->session()->flash('error','Confirm password not matching.');
            return redirect('sysadmin/change-password');
        }


        $result = User::where(['id'=>$request->session()->get('ADMIN_ID')])->first();
        if(!empty($result)){
           if(Hash::check($request->new_password,$result->password)){

                if($request->session()->get('ADMIN_ID') > 0 ){
                    $model = User::find($request->session()->get('ADMIN_ID'));
                    $model->password = bcrypt($request->new_password);
                    $model->temp_pass = $request->new_password;
                    $model->save();
                    $request->session()->flash('message','Password updated successfully.');
                    return redirect('sysadmin/change-password');
                }else{
                    return redirect('sysadmin');
                }
           }else{
              $request->session()->flash('error','Old password not matching.');
              return redirect('sysadmin/change-password');
           }
          
        }else{
           $request->session()->flash('error','Please login.');
           return redirect('sysadmin');
        }
       
    }
    
     public function edit(Request $request)
    {
        $request->validate([
            'restaurant_name'=>'required',
            'owner_name'=>'required',
            'latitude'=>'required',
            'owner_name'=>'required',
            'longitude'=>'required', 
             'email'=>'required',  
        ]);
        
        if($request->session()->get('REST_ID') > 0 ){
            $model = Restaurant::find($request->session()->get('REST_ID'));
            $model->restaurant_name = $request->post('restaurant_name');
            $model->owner_name = $request->post('owner_name');
            $model->mobile = $request->post('mobile');
            $model->email = $request->post('email');
            $model->address = $request->post('address');
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
            return redirect('restaurant/my-profile');
        }else{
            return redirect('restaurant');
        }
    }

}
