<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=Rating::select('ratings.*','users.name','users.mobile')
        ->leftJoin('users','users.id','=','ratings.user_id')->where('ratings.status',1);
        if($request->review !=""){
            $query = $query->where('ratings.review','LIKE','%'.$request->review.'%');
        }
        if($request->rating !=""){
            $query = $query->where('ratings.rating','LIKE','%'.$request->rating.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('ratings.created_date','>=',$request->from_date)->whereDate('ratings.created_date','<=',$request->to_date);
        }
        $data['data']=$query->orderBy('ratings.id','DESC')->get();
        return view('admin/rating/rating_list',$data);
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
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
