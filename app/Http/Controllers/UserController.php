<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Menu;
use App\Models\TravelRequest;
use App\Models\UserTransaction;
use App\Models\AddressBook;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportUser;
class UserController extends Controller
{
    public function index(Request $request){

        $query=User::where('status','!=','5')->whereIn('user_type',['USER','SUBADMIN']);
        if($request->name !=""){
            $query = $query->where('name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        return view('admin/user/user_list',$data);
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
                    ->where('travel_requests.user_id',$id);
                $query = $query->orderBy('travel_requests.id','DESC')->get();
                
                
                
                $result['tripdata'] = $query;
                
                
                $result['orders_sum'] = Order::where('status',1)->where('user_id',$id)->sum('grand_total');
                $result['orders_count'] = Order::where('status',1)->where('user_id',$id)->count();
                $result['wishlist'] = DB::table('favorites')->where('user_id',$id)->count();
                $result['orders'] = Order::where('status',1)->where('user_id',$id)->orderBy('id','DESC')->get();
                $result['logs'] = UserTransaction::where('user_id',$id)->orderBy('id','DESC')->get();
                $result['address'] = AddressBook::where('status','!=',5)->where('user_id',$id)->orderBy('id','DESC')->get();
                $result['data'] = User::where(['id'=>$id])->first();
                return view('admin/user/edit_user',$result);
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

        $arr = array(1,0);
        if($id > 0  AND $id !='' AND in_array($sts,$arr)){
    
            $model = User::find($id);
            $model->status = $sts;
            $model->save();
            $request->session()->flash('message','Status updated successfully.');
            return redirect('sysadmin/user-list');
        }else{
            $request->session()->flash('error','Invalid Info.');
            return redirect('sysadmin/user-list');
        }
    }
    
}
