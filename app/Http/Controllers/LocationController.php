<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['state'] = DB::table('states')->where('status',1)->orderBy('name')->get();

        $query  =Location::select('locations.*','states.name as state','cities.name as city')->leftJoin('states','states.id','=','locations.state_id')
        ->leftJoin('cities','cities.id','=','locations.city_id')->where('locations.status','!=',5);
       
        if($request->pincode !=""){
            $query = $query->where('locations.pincode',$request->pincode);
        }
        if($request->city_id !=""){
            $query = $query->where('locations.city_id',$request->city_id);
        }
        if($request->state_id !=""){
            $query = $query->where('locations.state_id',$request->state_id);
        }
        $query =$query->orderBy('locations.id','DESC')->get();
        $data['data'] = $query;
        return view('admin/location/location_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $data['state'] = DB::table('states')->where('status',1)->orderBy('name')->get();  
        return view('admin/location/add_location',$data);
    }

    public function get_city(Request $request)
    {
       
        $result = get_city($request->stateid);
       echo '<option value="">Select City</option>';
       foreach ($result as $key => $value) {
        echo '<option value="'.$value->id.'">'.$value->name.'</option>';
       }
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
            'state_id'=>'required',
            'city_id'=>'required',
            'pincode'=>'required',
            'region'=>'required',
            
        ]);
        
        
      
        $model = new Location();
        $model->state_id = $request->post('state_id');
        $model->city_id = $request->post('city_id');
        $model->location_name = $request->post('region');
        $model->pincode = $request->post('pincode');
        $model->created_date = date('Y-m-d');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Location added Successfully.');
        return redirect('sysadmin/location');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location,$id="")
    {
        if($id !=''){
            $result['state'] = DB::table('states')->where('status',1)->orderBy('name')->get();  
            $result['data'] = Location::where(['id'=>$id])->first();
            $result['city'] = DB::table('cities')->where('state_id',$result['data']->state_id)->where('status',1)->orderBy('name')->get();  
            return view('admin/location/edit_location',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'state_id'=>'required',
            'city_id'=>'required',
            'pincode'=>'required',
            'region'=>'required',
            'status'=>'required',   
            'hiddenid'=>'required',   
        ]);
        
        if($request->post('hiddenid') > 0 ){
    
            $model = Location::find($request->post('hiddenid'));
            $model->state_id = $request->post('state_id');
            $model->city_id = $request->post('city_id');
            $model->location_name = $request->post('region');
            $model->pincode = $request->post('pincode');
            $model->status = $request->post('status');
            $model->save();
            $request->session()->flash('message','Location updated successfully.');
            return redirect('sysadmin/location');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id="")
    {
        if($id > 0  AND $id !=''){
            $model = Location::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Location Deleted Successfully.');
            return redirect('sysadmin/location');
        }
    }
}
