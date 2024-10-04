<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Illuminate\Http\Request;

class TravelRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $query =TravelRequest::
            select('travel_requests.*','us.name as username','dv.name as dvname')
            ->leftjoin('users as us','us.id','=','travel_requests.user_id')
            ->leftjoin('drivers as dv','dv.id','=','travel_requests.driver_id')
            ->where('travel_requests.status','!=','5');
        if($request->status !=""){
            $query = $query->where('travel_requests.status',$request->status);
        }
        if($request->cancelBy !=""){
            $query = $query->where('travel_requests.cancel_desc',$request->cancelBy);
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('travel_requests.created_date','>=',$request->from_date)->whereDate('travel_requests.created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('travel_requests.id','DESC')->get();
        $data['data'] =$query; 
        return view('admin/trip/trip_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TravelRequest  $travelRequest
     * @return \Illuminate\Http\Response
     */
    public function show(TravelRequest $travelRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TravelRequest  $travelRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelRequest $travelRequest,$id="")
    {
         $query =TravelRequest::
            select('travel_requests.*','us.name as username','us.mobile as usermobile','dv.name as dvname','dv.mobile as dvmobile')
            ->leftjoin('users as us','us.id','=','travel_requests.user_id')
            ->leftjoin('drivers as dv','dv.id','=','travel_requests.driver_id')
            ->where('travel_requests.status','!=','5')
            ->where('travel_requests.id',$id)->first();
        
        
         $data['data'] =$query; 
        return view('admin/trip/trip_details',$data);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TravelRequest  $travelRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TravelRequest $travelRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TravelRequest  $travelRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelRequest $travelRequest)
    {
        //
    }
}
