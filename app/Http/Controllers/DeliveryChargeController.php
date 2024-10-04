<?php

namespace App\Http\Controllers;

use App\Models\DeliveryCharge;
use Illuminate\Http\Request;

class DeliveryChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=DeliveryCharge::where('status','!=',5);
        if($request->min_range !="" && $request->max_range !=""){
            $query = $query->where('min_range','>=',$request->min_range)->where('max_range','<=',$request->max_range);
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] = $query;
        return view('admin/delivery_charge/delivery_charge_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/delivery_charge/add_delivery_charge');
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
            // 'min_range'=>'required',
            // 'max_range'=>'required',
            'delivery_charge'=>'required', 
        ]);
        
        $model = new DeliveryCharge();
        // $model->min_range = $request->post('min_range');
        // $model->max_range = $request->post('max_range');
        $model->delivery_charge = $request->post('delivery_charge');
        $model->created_date = date('Y-m-d');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Delivery Charge added Successfully.');
        return redirect('sysadmin/delivery-charge');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryCharge  $deliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryCharge $deliveryCharge,$id="")
    {
        if($id !=''){
             
            $result['data'] = DeliveryCharge::where(['id'=>$id])->first();
            
            return view('admin/delivery_charge/edit_delivery_charge',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryCharge  $deliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DeliveryCharge $deliveryCharge)
    {
        $request->validate([
            // 'min_range'=>'required',
            // 'max_range'=>'required',
            'delivery_charge'=>'required', 
        ]);
        
        if($request->post('hiddenid') > 0 ){
    
            $model = DeliveryCharge::find($request->post('hiddenid'));
            // $model->min_range = $request->post('min_range');
            // $model->max_range = $request->post('max_range');
            $model->delivery_charge = $request->post('delivery_charge');
            $model->status = $request->post('status');
            $model->save();
            $request->session()->flash('message','Delivery Charge updated successfully.');
            return redirect('sysadmin/delivery-charge');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryCharge  $deliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryCharge $deliveryCharge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryCharge  $deliveryCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DeliveryCharge $deliveryCharge,$id="")
    {
        if($id > 0  AND $id !=''){
            $model = DeliveryCharge::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Delivery Charge Deleted Successfully.');
            return redirect('sysadmin/delivery-charge');
        }
    }
}
