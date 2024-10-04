<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data']=ProductAttribute::where('status','!=','5')->orderBy('id','DESC')->get();
        return view('restaurant/product_attributes/product_attributes_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant/product_attributes/add_product_attributes');
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
            'title'=>'required',   
        ]);
        
        
      
        $model = new ProductAttribute();
        $model->attribute_title = $request->post('title');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Attribute added successfully.');
        return redirect('restaurant/attributes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductAttribute  $productAttribute
     * @return \Illuminate\Http\Response
     */
    public function show(ProductAttribute $productAttribute,$id="")
    {
        if($id !=''){
            $result['data'] = ProductAttribute::where(['id'=>$id])->first();
            return view('restaurant/product_attributes/edit_product_attributes',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductAttribute  $productAttribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'title'=>'required',
        ]);
         if($request->post('hiddenid') > 0 ){
    
             $model = ProductAttribute::find($request->post('hiddenid'));
             $model->attribute_title = $request->post('title');
             $model->status = $request->post('status');
             $model->save();
             $request->session()->flash('message','Attribute Updated Successfully');
             return redirect('restaurant/attributes');
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductAttribute  $productAttribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductAttribute $productAttribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductAttribute  $productAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id="")
    {
        if($id > 0  AND $id !=''){
    
            $model = ProductAttribute::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Attribute Deleted Successfully');
            return redirect('restaurant/attributes');
        }
    }
}
