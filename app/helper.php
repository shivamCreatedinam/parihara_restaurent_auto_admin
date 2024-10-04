<?php 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
date_default_timezone_set("Asia/Calcutta");

if(!function_exists('my_date')){
    function my_date(){
    return $date = Carbon::now('Asia/Kolkata')->format('Y-m-d');
    }
}
if(!function_exists('my_time')){
    function my_time(){
    return $time = Carbon::now('Asia/Kolkata')->format('h:i a');
    }
}
function product_image($id){
        $data = DB::table('product_image')->where('product_id',$id)->first();
        if(!empty($data)){
            return $data->image;
        }else{
            return ;
        }
}

function product_image_list($id){
    $data = DB::table('product_image')->where('product_id',$id)->get();
    if(count($data) > 0 ){
        return $data;
    }else{
        return array();
    }
}

function product_selected_attris($prod){
    return $data = DB::table('prod_selctd_attris')
    ->select('prod_selctd_attris.*','product_attributes.attribute_title')
    ->leftJoin('product_attributes','product_attributes.id','=','prod_selctd_attris.attributes_id')
    ->where('prod_selctd_attris.product_id',$prod)->first();
    // if(count($data) > 0 ){
    //   foreach ($data as $key => $value) {
    //     $value->image = product_image($value->product_id); 
      
    //     $data1[] = $value;
    //   }
    //   return $data1;
    // }else{
    //   return array();
    // }
}

function ordered_product_list($order_number){
    $data = DB::table('order_products')
    ->select('order_products.*','products.product_name','products.description')
    ->leftJoin('products','products.id','=','order_products.product_id')
    ->where('order_products.order_number',$order_number)->get();
    if(count($data) > 0 ){
      foreach ($data as $key => $value) {
        $value->image = product_image($value->product_id); 
      
        $data1[] = $value;
      }
      return $data1;
    }else{
      return array();
    }
}


if(!function_exists('check_promocode')){
    function check_promocode($promocode){
     return $check = DB::table('coupons')
             ->where('coupon_code','=',$promocode)
             ->where('status',1)
             ->first();         
 }
 }


function selected_coupon_user($userid,$couponid){
    $data = DB::table('coupon_selected_users')->where('user_id',$userid)->where('coupon_id',$couponid)->get();
    if(count($data) > 0 ){
        return true;
    }else{
        return false;
    }
}


function notification_selected_users($userid,$notificationid){
    $data = DB::table('notification_selected_users')->where('user_id',$userid)->where('notification_id',$notificationid)->get();
    if(count($data) > 0 ){
        return true;
    }else{
        return false;
    }
}

function get_city($stateid){
   return $data = DB::table('cities')->where('state_id',$stateid)->where('status',1)->orderBy('name')->get();
    
}

if(!function_exists('user_exist')){
    function user_exist($id){
     $check = DB::table('users')
             ->where('id','=',$id)
             ->where('status',1)
             ->count();
             if ($check > 0) {
               return true;
             }else{
               return false;
             }
 }
 }

 if(!function_exists('order_status')){
    function order_status(){
    return $check = DB::table('order_status')
             ->where('status',1)
             ->orderBy('order_sort','ASC')->get();
             
 }
 }


 if(!function_exists('user_menus')){
    function user_menus($userid){
        if($userid == 'ADMIN'){
          return $check = DB::table('user_menu_permsins')
            ->select('menus.menu_title','menus.id as menuid','menus.menu_link','menus.icons','menus.ex_sub_menus')
            ->leftJoin('users','users.id','=','user_menu_permsins.user_id')
            ->leftJoin('menus','menus.id','=','user_menu_permsins.menu_id')
             ->where('user_menu_permsins.status',1)
             ->orderBy('user_menu_permsins.id','ASC')->get();  
        }else{
            return $check = DB::table('user_menu_permsins')
            ->select('menus.menu_title','menus.id as menuid','menus.menu_link','menus.icons','menus.ex_sub_menus')
            ->leftJoin('users','users.id','=','user_menu_permsins.user_id')
            ->leftJoin('menus','menus.id','=','user_menu_permsins.menu_id')
             ->where('user_menu_permsins.status',1)
              ->where('users.user_id',$userid)
             ->orderBy('user_menu_permsins.id','ASC')->get();
        }
    
             
 }
 }
 
 
 if(!function_exists('user_sub_menus')){
    function user_sub_menus($menuid){
        if($userid == 'ADMIN'){
          return $check = DB::table('user_menu_permsins')
            ->select('menus.menu_title','menus.id as menuid','menus.menu_link','menus.icons','menus.ex_sub_menus')
            ->leftJoin('users','users.id','=','user_menu_permsins.user_id')
            ->leftJoin('menus','menus.id','=','user_menu_permsins.menu_id')
             ->where('user_menu_permsins.status',1)
             ->orderBy('user_menu_permsins.id','ASC')->get();  
        }else{
            return $check = DB::table('user_menu_permsins')
            ->select('menus.menu_title','menus.id as menuid','menus.menu_link','menus.icons','menus.ex_sub_menus')
            ->leftJoin('users','users.id','=','user_menu_permsins.user_id')
            ->leftJoin('menus','menus.id','=','user_menu_permsins.menu_id')
             ->where('user_menu_permsins.status',1)
              ->where('users.user_id',$userid)
             ->orderBy('user_menu_permsins.id','ASC')->get();
        }
    
             
 }
 }

?>