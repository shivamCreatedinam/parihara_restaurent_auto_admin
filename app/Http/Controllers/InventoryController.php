<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=Inventory::select('inventories.*','categories.category_name')
        ->join('categories','categories.id','=','inventories.category_id')
        ->where('inventories.status','!=','5');
        if($request->name !=""){
            $query = $query->where('inventories.product_name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('inventories.created_at','>=',$request->from_date)->whereDate('inventories.created_at','<=',$request->to_date);
        }
        $query = $query->orderBy('inventories.id','DESC')->get();
        $data['data'] =$query; 
        return view('admin/inventory/inventory_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category']=Category::where('status',1)->orderBy('id','DESC')->get();
        
        return view('admin/inventory/add_inventory',$data);
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
            'product_name'=>'required',   
            'qty'=>'required',   
            // 'return_qty'=>'required',  
            // 'stolen_product'=>'required', 
            // 'damaged_expired'=>'required',  
            // 'description'=>'required', 
        ]);
        
        $getid = Inventory::max('id');
        if(!empty($getid)){
            $maxid = $getid;        
        }else{
            $maxid = 1;
        }
        $UID = "PR0".$maxid; 
        
        
      
        $model = new Inventory();
        $model->category_id = $request->post('category_id');
        $model->product_name = $request->post('product_name');
        $model->product_code = $UID;
        $model->qty = $request->post('qty');
        $model->return_qty = $request->post('return_qty');
        $model->stolen_product = $request->post('stolen_product');
        $model->damaged_expired = $request->post('damaged_expired');
        $model->description = $request->post('description');
        $model->created_date = date('Y-m-d');
        $model->created_time = date('h:i a');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Inventory added successfully.');
        return redirect('sysadmin/inventory-list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory,$id="")
    {
        if($id !=''){
            $result['category']=Category::where('status',1)->orderBy('id','DESC')->get();
            $result['data'] = Inventory::where(['id'=>$id])->first();
            return view('admin/inventory/edit_inventory',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'product_name'=>'required',   
            'qty'=>'required',   
            // 'return_qty'=>'required',  
            // 'stolen_product'=>'required', 
            // 'damaged_expired'=>'required',  
            // 'description'=>'required',
            'hiddenid'=>'required',  
        ]);
        
        if($request->post('hiddenid') > 0 ){
    
            $model = Inventory::find($request->post('hiddenid'));
            $model->category_id = $request->post('category_id');
            $model->product_name = $request->post('product_name');
            $model->qty = $request->post('qty');
            $model->return_qty = $request->post('return_qty');
            $model->stolen_product = $request->post('stolen_product');
            $model->damaged_expired = $request->post('damaged_expired');
            $model->description = $request->post('description');
            $model->status = $request->post('status');
            $model->save();
            $request->session()->flash('message','Inventory updated successfully.');
            return redirect('sysadmin/inventory-list');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Inventory $inventory,$id="")
    {
        if($id > 0  AND $id !=''){
    
            $model = Inventory::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Inventory Deleted Successfully.');
            return redirect('sysadmin/inventory-list');
        }
    }
}
