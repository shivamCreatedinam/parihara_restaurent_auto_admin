<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProdSelctdAttri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
date_default_timezone_set("Asia/Calcutta");
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $query=Product::select('products.*','categories.category_name')
        ->join('categories','categories.id','=','products.category_id')
        ->where('products.status','!=','5');
        if($request->name !=""){
            $query = $query->where('products.product_name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('products.created_date','>=',$request->from_date)->whereDate('products.created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('products.id','DESC')->get();
        $data['data'] =$query; 
        return view('restaurant/product/product_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category']=Category::where('status',1)->orderBy('id','DESC')->get();
        $data['attributes']=ProductAttribute::where('status',1)->orderBy('id','DESC')->get();
        return view('restaurant/product/add_product',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $resid = $request->session()->get('REST_ID');
           
         if($resid !=''){
                $request->validate([
                    'category_id'=>'required',
                    'product_name'=>'required',   
                    'description'=>'required', 
                ]);
                
        $getid = Product::max('id');
        if(!empty($getid)){
            $maxid = $getid;        
        }else{
            $maxid = 1;
        }
        $UID = "PR0".$maxid; 
        
        $sizecount = sizeof($request->post('size1'));
        
      
        $model = new Product();
        if($request->hasfile('image')){
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
           
            $image->move(public_path('uploads/category_image'), $image_name);
            $model->image = "uploads/category_image/".$image_name;
        }
       
        $model->restaurant_id = $resid;
        $model->category_id = $request->post('category_id');
        $model->attribute_id = $request->post('attribute_id');
        $model->product_name = $request->post('product_name');
        $model->product_code = $UID;
        $model->market_price = 0;
        $model->discount = 0;
        $model->sale_price = 0;
        $model->qty = 0;
        $model->description = $request->post('description');
        $model->created_date = date('Y-m-d');
        $model->created_time = date('h:i a');
        $model->status = 1;
        if($model->save()){

            for ($i=0; $i < $sizecount; $i++) { 
                $inseratt =  DB::table('prod_selctd_attris')->insert([
                    'product_id' => $model->id,
                    'attributes_id' => $request->post('size1')[$i],
                    'mrp' => $request->post('mrp1')[$i],
                    'saling_price' =>$request->post('sp_price1')[$i],
                    'discount' =>$request->post('discount1')[$i],
                    'qty' =>$request->post('qty1')[$i],
                ]);  
            }

            if($request->hasfile('Image'))
                     {
                        foreach($request->file('Image') as $file)
                        {
                            $name = time().rand(1,100).'.'.$file->extension();
                            // $file->storeAs('/public/uploads/product_image',$name);
                            $file->move(public_path('uploads/product_image'), $name);
                            
                            $image = "uploads/product_image/".$name;
                            DB::table('product_image')->insert([
                                'product_id' => $model->id,
                                'image' => $image
                            ]);  
                        }
                     }
             }
            
                    $userData = DB::table('users')->select('firbase_token')->where('status',1)->get();
                    $imageData = DB::table('product_image')->where('product_id', $model->id)->first();
                    if(count($userData) > 0){
                    $SERVER_API_KEY = 'AAAA-U9pcl8:APA91bHUxIUGXEyvAYB3xtLMhxdc8m1wBoPJ0jpBoUyrvGrgWdBmI4TrzHS6mPaWV1d_itmT4dYuOVI52PBxZn28igAnP-Ccl4ouqYxjOp3tjoATHVxDSaODxkCBKS6et-WFedwpo64-';
                    define( 'API_ACCESS_KEY', $SERVER_API_KEY );
                        foreach($userData as $uData){
                            if($uData->firbase_token !=''){
                             
                         
                                    $fcmMsg = array(
                                        'title' =>  $request->post('product_name')." Item added, please checkout and enjoy your delicious food",
                                        'body' =>$request->post('product_name')." Item added, please checkout and enjoy your delicious food",
                                        'sound' => 'noti_sound1.wav',
                                        'android_channel_id' => 'restaurent_channel',
                                      );
                                      $fcmFields = array(
                                        'to' => $uData->firbase_token, //tokens sending for notification
                                        'notification' => $fcmMsg,
                                        'data'=>$imageData,
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
                          
                    }
            
            $request->session()->flash('message','Product added successfully.');
            return redirect('restaurant/product-list');     
         }else{
             $request->session()->flash('error','Access denied');
             return redirect('restaurant/login');
         }
      
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,$id="")
    {
        if($id !=''){
            $result['category']=Category::where('status',1)->orderBy('id','DESC')->get();
            $result['attributes']=ProductAttribute::where('status',1)->orderBy('id','DESC')->get();
            $result['data'] = Product::where(['id'=>$id])->first();
            return view('restaurant/product/edit_product',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'attribute_id'=>'required',   
            'product_name'=>'required',   
            'market_price'=>'required',   
            'discount'=>'required',  
            'sale_price'=>'required', 
            'qty'=>'required',  
            'description'=>'required', 
        ]);
        
        if($request->post('hiddenid') > 0 ){
    
            $model = Product::find($request->post('hiddenid'));
            $model->category_id = $request->post('category_id');
            $model->attribute_id = $request->post('attribute_id');
            $model->product_name = $request->post('product_name');
            $model->market_price = $request->post('market_price');
            $model->discount = $request->post('discount');
            $model->sale_price = $request->post('sale_price');
            $model->qty = $request->post('qty');
            $model->description = $request->post('description');
           
            $model->status = $request->post('status');
            if($model->save()){
                if($request->hasfile('Image'))
                         {
                            foreach($request->file('Image') as $file)
                            {
                                $name = time().rand(1,100).'.'.$file->extension();
                                $file->move(public_path('uploads/product_image'), $name);
                                $image = "uploads/product_image/".$name;
                                DB::table('product_image')->insert([
                                    'product_id' => $model->id,
                                    'image' => $image
                                ]);  
                            }
                         }
            }
            $request->session()->flash('message','Product updated successfully.');
            return redirect('restaurant/product-list');

        }
        
      
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Product $product,$id)
    {
        if($id > 0  AND $id !=''){
    
            $model = Product::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Product Deleted Successfully.');
            return redirect('restaurant/product-list');
        }
    }

    public function deals_week(Request $request,$sts,$id){

        $arr = array(1,0);
        if($id > 0  AND $id !='' AND in_array($sts,$arr)){
    
            $model = Product::find($id);
            $model->deals_of_week = $sts;
            $model->save();
            $request->session()->flash('message','Status updated successfully.');
            return redirect('restaurant/product-list');
        }else{
            $request->session()->flash('error','Invalid Info.');
            return redirect('restaurant/product-list');
        }
    }

    public function product_popular(Request $request,$sts,$id){

        $arr = array(1,0);
        if($id > 0  AND $id !='' AND in_array($sts,$arr)){
    
            $model = Product::find($id);
            $model->popular = $sts;
            $model->save();
            $request->session()->flash('message','Status updated successfully.');
            return redirect('restaurant/product-list');
        }else{
            $request->session()->flash('error','Invalid Info.');
            return redirect('restaurant/product-list');
        }
    }

    
}
