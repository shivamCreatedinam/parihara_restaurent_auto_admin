<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=Offer::select('offers.*','categories.category_name','products.product_name')
        ->join('categories','categories.id','=','offers.category_id')
        ->leftjoin('products','products.id','=','offers.product_id')
        ->where('offers.status','!=',5);
        if($request->offer !=""){
            $query = $query->where('offers.offer_name',$request->offer);
        }
        if($request->offer_type !=""){
            $query = $query->where('offers.offer_type',$request->offer_type);
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('offers.offer_expires_on','>=',$request->from_date)->whereDate('offers.offer_expires_on','<=',$request->to_date);
        }
        $query = $query->orderBy('offers.id','DESC')->get();
        $data['data'] =$query; 
        
        return view('admin/offer/offer_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category']=Category::where('status',1)->orderBy('id','DESC')->get();
        $data['product']=Product::where('status',1)->orderBy('id','DESC')->get();
        return view('admin/offer/add_offer',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'product_id'=>'required',
            'offer_type'=>'required',
            'offer_title'=>'required',
            'offer_start_from'=>'required',
            'offer_expires_on'=>'required',
        ]);
        
        
      
        $model = new Offer();
        $model->category_id = $request->post('category_id');
        $model->product_id = $request->post('product_id');
        $model->offer_name = $request->post('offer_title');
        $model->offer_type = $request->post('offer_type');
        $model->offer_start_from = $request->post('offer_start_from');
        $model->offer_expires_on = $request->post('offer_expires_on');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Offer added Successfully.');
        return redirect('sysadmin/offers');
    }
    
    public function get_product(Request $request){
        if(isset($_POST['id'])){
             	echo '<option value="">Select Product</option>';
            $product = Product::where('status',1)->where('category_id',$_POST['id'])->orderBy('id','DESC')->get();
            	foreach ($product as $key => $value) {
				
				echo '<option value="'.$value->id.'">'.$value->product_name.'</option>';
				
			    }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer,$id="")
    {
        if($id !=''){
            $data['category']=Category::where('status',1)->orderBy('id','DESC')->get();
            
            $data['data'] = Offer::where(['id'=>$id])->first();
            if(!empty($data['data'])){
                $data['product']=Product::where('status',1)->where('category_id',$data['data']->category_id)->orderBy('id','DESC')->get();
            }else{
                $data['product']=array();
            }
            
            return view('admin/offer/edit_offer',$data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'product_id'=>'required',
            'offer_type'=>'required',
            'offer_title'=>'required',
            'offer_start_from'=>'required',
            'offer_expires_on'=>'required',
            'hiddenid'=>'required',
        ]);
        
        if($request->post('hiddenid') > 0 ){
      
        $model = Offer::find($request->post('hiddenid'));
        $model->category_id = $request->post('category_id');
        $model->product_id = $request->post('product_id');
        $model->offer_name = $request->post('offer_title');
        $model->offer_type = $request->post('offer_type');
        $model->offer_start_from = $request->post('offer_start_from');
        $model->offer_expires_on = $request->post('offer_expires_on');
        $model->status = $request->post('status');
        $model->save();
        $request->session()->flash('message','Offer updated Successfully.');
        return redirect('sysadmin/offers');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id="")
    {
        if($id > 0  AND $id !=''){
            $model = Offer::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Offer Deleted Successfully.');
            return redirect('sysadmin/offers');
        }
    }
}
