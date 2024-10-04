<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportErning;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('order_products')->select('order_products.*','orders.discount_amount','orders.delvery_charge','orders.payment_mode','orders.payment_status','orders.order_status' 
        ,'orders.created_date','orders.created_time','orders.full_name'
        ,'products.product_name','categories.category_name')
        ->join('orders','orders.id','=','order_products.order_id')
        ->leftJoin('products','products.id','=','order_products.product_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->where('orders.status',1);
        if($request->order_number !=''){
            $query = $query->where('orders.order_number',$request->order_number);
        }
        if($request->payment_status !=''){
            $query = $query->where('orders.payment_status',$request->payment_status);
        }else{
            // $query = $query->where('orders.payment_status','Delivered');
        }
        if($request->payment_mode !=''){
            $query = $query->where('orders.payment_mode',$request->payment_mode);
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('orders.created_date','>=',$request->from_date)->whereDate('orders.created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('order_products.id','DESC')->get();
       
        $data['data'] = $query;
        
        return view('admin/earning/earning_list',$data);
    }


    public function report(Request $request)
    {
        $query = DB::table('order_products')->select('order_products.*','orders.delvery_charge','orders.payment_mode','orders.payment_status','orders.order_status' 
        ,'orders.created_date','orders.created_time','orders.full_name'
        ,'products.product_name','products.qty as pqty','categories.category_name')
        ->join('orders','orders.id','=','order_products.order_id')
        ->leftJoin('products','products.id','=','order_products.product_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->where('orders.status',1);
       
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('orders.created_date','>=',$request->from_date)->whereDate('orders.created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('order_products.id','DESC')->get();
       
        $data['data'] = $query;
        
        return view('admin/report/report_list',$data);
    }
    public function exportEr(Request $request){
        return Excel::download(new ExportErning, 'Earning.xlsx');
    }
}
