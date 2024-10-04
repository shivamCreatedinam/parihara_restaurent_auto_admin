<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportErning implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
          $query = DB::table('order_products')->select('order_products.order_number','order_products.order_number',
         'orders.full_name','products.product_name','categories.category_name','order_products.qty','order_products.price',
         'orders.delvery_charge','order_products.total_price as total_price','orders.payment_mode',
        'orders.payment_status','orders.order_status' 
        ,'orders.created_date','orders.created_time'
        )
        ->join('orders','orders.id','=','order_products.order_id')
        ->leftJoin('products','products.id','=','order_products.product_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->where('orders.status',1)->orderBy('order_products.id','DESC')->get();
       $data = array();
       foreach($query as $value){
           $value->total_price = $value->delvery_charge+$value->total_price;
           $data[] =  $value;
       }
       return $data;
    }
    public function headings(): array
    {
        return [
            'Order Number',
            'Invoice No',
            'Name',
           
            'Products',
            'Categories',
            'Qty',
            // 'Return Qty',
            'Net Amount',
            'Delivery Charge',
            'Total Amount',
            // 'Return Amount',
            // 'Margin',
            'Payment Mode',
            'Payment Status',
            'Order Status',
            'Created Date',
            'Created Time',
        ];
    }
}
