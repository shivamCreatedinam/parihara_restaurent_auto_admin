<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\TravelRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       return view('admin/login');
    }

    public function auth(Request $request)
    {
      $email = $request->post('email');
      $password = $request->post('password');

      // $result = Admin::where(['email'=>$email,'password'=>$password])->get();
      $result = DB::table('admins')->where(['email'=>$email])->first();
      if($result){
         if(Hash::check($password,$result->password)){
            $request->session()->put('ADMIN_LOGIN',true);
            $request->session()->put('ADMIN_ID',$result->id);
            // $request->session()->put('ADMIN_USERID',$result->user_id);
            $request->session()->put('ADMIN',$result->name);
            $request->session()->put('ADMINEMAIL',$result->email);
            return redirect('sysadmin/dashboard');
         }else{
            $request->session()->flash('error','Please enter correct password.');
            return redirect('sysadmin');
         }
        
      }else{
         $request->session()->flash('error','Please enter valid Email ID');
         return redirect('sysadmin');
      }
    }

    public function dashboard(Request $request)
    {
        $data['users'] = User::whereIn('user_type',['USER','SUBADMIN'])->count();
        $data['stock_product'] = Product::where('qty','!=','0')->where('status','!=','5')->count();
        $data['out_of_stock_product'] = Product::where('qty','=','0')->where('status','!=','5')->count();
        $data['categories'] = Category::where('status','!=','5')->count();

        $data['totaltrip'] = TravelRequest::count();
        $data['completetrip'] = TravelRequest::where('status',3)->count();
        $data['runningtrip'] = TravelRequest::where('status',2)->count();
        $data['recentcreatedtrip'] = TravelRequest::whereIn('status',[0,1])->count();
        $data['usercanceltrip'] = TravelRequest::where('cancel_desc','User')->where('status','4')->count();
        $data['drivercanceltrip'] = TravelRequest::where('cancel_desc','Driver')->where('status','4')->count();
        $data['totalearntrip'] = TravelRequest::where('status','3')->sum('price');
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
       
       return view('admin/dashboard',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        return view('admin/change_password');
    }
    public function setPrice(Request $request)
    {
        
         $data['prices'] = DB::table('set_prices')->where('id','1')->where('status','1')->first();
        return view('admin/set_price',$data);
    }
    public function my_profile(Request $request)
    {
        $data['data'] = User::whereIn('user_type',['ADMIN','SUBADMIN'])->where('id',$request->session()->get('ADMIN_ID'))->first();
        
        return view('admin/my_profile',$data);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'mobile'=>'required', 
            // 'email'=>'required',  
        ]);
        
        if($request->session()->get('ADMIN_ID') > 0 ){
            $model = User::find($request->session()->get('ADMIN_ID'));
            $model->name = $request->post('name');
            $model->mobile = $request->post('mobile');
            // $model->email = $request->post('email');
            $model->save();
            $request->session()->flash('message','Profile updated successfully.');
            return redirect('sysadmin/my-profile');
        }else{
            return redirect('sysadmin');
        }
    }
    public function update_price(Request $request)
    {
        $request->validate([
            'value'=>'required',
            'night_shift'=>'required',
        ]);
        
        if($request->session()->get('ADMIN_ID') > 0 ){
             $update =  DB::table('set_prices')->where('id','1')->update(array(
                 'value'=>$request->value,
                 'night_shift'=>$request->night_shift,
                 ));
           
            $request->session()->flash('message','Price updated successfully.');
            return redirect('sysadmin/set-price');
        }else{
            return redirect('sysadmin');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
