<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\TravelRequest;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request){

        $query=Driver::where('status','!=','5');
        if($request->name !=""){
            $query = $query->where('name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        return view('admin/drivers/drivers_list',$data);
    }

    public function sub_admin_index(Request $request){



        $query=User::where('status','!=','5')
        ->where('user_type','SUBADMIN');
        if($request->name !=""){
            $query = $query->where('name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        return view('admin/sub_admin/sub_admin_list',$data);
    }

    

    public function create(){

        
        return view('admin/user/add_user');
    }
    public function sub_admin_create(){
        
        $data['menu'] = Menu::where('status',1)->get();

        return view('admin/sub_admin/add_sub_admin',$data);
    }

    
    public function store(Request $request){

        
        $request->validate([
            'name'=>'required',
            'mobile'=>'required|min:10|max:10|unique:users', 
            'email'=>'required|email|unique:users',   
            'password'=>'required', 
        ]);
        
        
      $getid = User::max('id');
      
      $menuid = sizeof($request->post('selected_user_id'));
        if(!empty($getid)){
            $maxid = $getid;        
        }else{
            $maxid = 1;
        }
        $UID = "USR0".$maxid; 
        
        $model = new User();
       
        $model->name = $request->post('name');
        $model->user_id = $UID;
        $model->user_type = "SUBADMIN";
        $model->email = $request->post('email');
        $model->mobile = $request->post('mobile');
        $model->password = bcrypt($request->password);
        $model->temp_pass = $request->password;
        $model->created_date = my_date();
        $model->created_time = my_time();
        $model->user_activate = 1;
        $model->status = 1;
        if($model->save()){
            
              for ($i=0; $i < $menuid; $i++) { 
                $inseratt =  DB::table('user_menu_permsins')->insert([
                    'user_id' => $model->id,
                    'menu_id' => $request->post('selected_user_id')[$i],
                    'status' =>1,
                    'created_date' =>date('Y-m-d'),
                    'created_time' =>date('h:i:s a'),
                ]);  
            }
        
        $request->session()->flash('message','Sub Admin added successfully.');
        return redirect('sysadmin/sub-admin-list');
        }
       
    }

    public function show($id=""){
            if($id !=""){
                
                 $query =TravelRequest::
                    select('travel_requests.*','us.name as username','dv.name as dvname')
                    ->leftjoin('users as us','us.id','=','travel_requests.user_id')
                    ->leftjoin('drivers as dv','dv.id','=','travel_requests.driver_id')
                    ->where('travel_requests.status','!=','5')
                    ->where('travel_requests.driver_id',$id);
                $query = $query->orderBy('travel_requests.id','DESC')->get();
                
                
                $result['data'] = Driver::where(['id'=>$id])->first();
                $result['tripdata'] = $query;
                $result['totalearn'] = TravelRequest::where('status',3)->where('driver_id',$id)->sum('price');
                return view('admin/drivers/edit_drivers',$result);
            }
    }

    public function sub_admin_show($id=""){
        if($id !=""){
            $result['orders'] = Order::where('status',1)->where('user_id',$id)->orderBy('id','DESC')->get();
            $result['address'] = AddressBook::where('status','!=',5)->where('user_id',$id)->orderBy('id','DESC')->get();
            $result['data'] = User::where(['id'=>$id])->first();
            return view('admin/user/edit_user',$result);
        }
    }
    

    public function exportUsers(Request $request){
        return Excel::download(new ExportUser, 'users.xlsx');
    }
    
    public function update_status(Request $request,$sts,$id){

        $arr = array(1,0,2);
        if($id > 0  AND $id !='' AND in_array($sts,$arr)){
    
            $model = Driver::find($id);
            $model->status = $sts;
            if($sts == 0){
            $model->verified = 'No';    
            }
            
            if($sts == 1){
            $model->verified = 'Yes';    
            }
            if($sts == 1){
            $model->verified = 'Yes';    
            }
            
            $model->save();
            $request->session()->flash('message','Status updated successfully.');
            return redirect('sysadmin/drivers-list');
        }else{
            $request->session()->flash('error','Invalid Info.');
            return redirect('sysadmin/drivers-list');
        }
    }
   
}
