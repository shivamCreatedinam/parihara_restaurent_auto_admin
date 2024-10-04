<?php

namespace App\Http\Controllers;

use App\Models\Estimated_delivery;
use Illuminate\Http\Request;

class EstimatedDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data']=Estimated_delivery::where('status','!=',5)->orderBy('id','DESC')->get();
        return view('admin/estimated/estimated_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/estimated/add_estimated');
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
            'distance'=>'required',
            'distance_to'=>'required',
            'days'=>'required',
        ]);
        
        $model = new Estimated_delivery();
        $model->estimated_km = $request->post('distance');
        $model->estimated_to = $request->post('distance_to');
        $model->days = $request->post('days');
        
        $model->created_date = date('Y-m-d');
        $model->created_time = date('h:i:s a');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Estimated Delivery Days added Successfully.');
        return redirect('sysadmin/estimated-days');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estimated_delivery  $estimated_delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Estimated_delivery $estimated_delivery,$id)
    {
        if($id !=''){
             
            $result['data'] = Estimated_delivery::where(['id'=>$id])->first();
            
            return view('admin/estimated/edit_estimated',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estimated_delivery  $estimated_delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Estimated_delivery $estimated_delivery)
    {
        $request->validate([
            'distance'=>'required',
            'days'=>'required',
        ]);
        
        if($request->post('hiddenid') > 0 ){
    
            $model = Estimated_delivery::find($request->post('hiddenid'));
            $model->estimated_km = $request->post('distance');
            $model->estimated_to = $request->post('distance_to');
            $model->days = $request->post('days');
            $model->status = $request->post('status');
            $model->save();
            $request->session()->flash('message','Estimated Delivery Days updated successfully.');
            return redirect('sysadmin/estimated-days');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estimated_delivery  $estimated_delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estimated_delivery $estimated_delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estimated_delivery  $estimated_delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Estimated_delivery $estimated_delivery,$id="")
    {
        if($id > 0  AND $id !=''){
            $model = Estimated_delivery::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Estimated Delivery Days Deleted Successfully.');
            return redirect('sysadmin/estimated-days');
        }
    }
}
