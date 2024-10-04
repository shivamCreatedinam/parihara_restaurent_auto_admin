<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data']=Slot::where('status','!=',5)->orderBy('id','DESC')->get();
        
        return view('admin/slots/slots_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/slots/add_slots');
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
            'from_range'=>'required',
            'to_range'=>'required',
             
        ]);
        
        $model = new Slot();
        $model->from_range = $request->post('from_range');
        $model->to_range = $request->post('to_range');
        $model->created_date = date('Y-m-d');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Delivery slots added Successfully.');
        return redirect('sysadmin/slots');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function show(Slot $slot,$id="")
    {
        if($id !=''){
             
            $result['data'] = Slot::where(['id'=>$id])->first();
            return view('admin/slots/edit_slots',$result);
        }
    }


    public function general_setting(Request $request)
    {
          
            $result['order_status'] = DB::table('order_cancel_permission')
            ->where(['id'=>1])->first();
            $result['general'] = DB::table('general_settings')
            ->where(['id'=>1])->first();
            return view('admin/slots/add_general_settings',$result);
       
    }

    public function update_order_status(Request $request)
    {
        $order_placed =$request->order_placed !='' ? $request->order_placed : 'no';
        $order_confirmed = $request->order_confirmed!='' ? $request->order_confirmed : 'no';
        $processing = $request->processing!='' ? $request->processing : 'no';
        $dispatched = $request->dispatched!='' ? $request->dispatched : 'no';
        $delivered = $request->delivered!='' ? $request->delivered : 'no';
        

             $update = DB::table('order_cancel_permission')
             ->where(['id'=>1])->update(array(
                    'order_placed'=>$order_placed,
                    'order_confirmed'=>$order_confirmed,
                    'processing'=>$processing,
                    'dispatched'=>$dispatched,
                    'delivered'=>$delivered,
             ));
             $request->session()->flash('message','Updated successfully.');
             return redirect('sysadmin/general-settings');
       
    }

    public function update_general_status(Request $request)
    {
        $return_product_in_days =$request->return_product_in_days !='' ? $request->return_product_in_days : '0';
        $minimum_order_value = $request->minimum_order_value!='' ? $request->minimum_order_value : '0';
        $esti_deli_in_kms = $request->esti_deli_in_kms!='' ? $request->esti_deli_in_kms : '0';
        $esti_days = $request->esti_days!='' ? $request->esti_days : '0';
       
        

             $update = DB::table('general_settings')
             ->where(['id'=>1])->update(array(
                    'return_product_in_days'=>$return_product_in_days,
                    'minimum_order_value'=>$minimum_order_value,
                    'esti_deli_in_kms'=>$esti_deli_in_kms,
                    'esti_days'=>$esti_days,
                  
             ));
             $request->session()->flash('message','Updated successfully.');
             return redirect('sysadmin/general-settings');
       
    }
    


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Slot $slot)
    {
        $request->validate([
            'from_range'=>'required',
            'to_range'=>'required',
            'hiddenid'=>'required',
        ]);
        
        if($request->post('hiddenid') > 0 ){
    
            $model = Slot::find($request->post('hiddenid'));
            $model->from_range = $request->post('from_range');
            $model->to_range = $request->post('to_range');
            $model->status = $request->post('status');
            $model->save();
            $request->session()->flash('message','Delivery slots updated successfully.');
            return redirect('sysadmin/slots');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slot $slot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Slot $slot,$id="")
    {
        if($id > 0  AND $id !=''){
            $model = Slot::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Delivery slots Deleted Successfully.');
            return redirect('sysadmin/slots');
        }
    }
}
