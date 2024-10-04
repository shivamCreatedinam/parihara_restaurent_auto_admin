<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] =ContactQuery::orderBy('id','DESC')->get();
        
        return view('admin/query/query_list',$data);
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
     * @param  \App\Models\ContactQuery  $contactQuery
     * @return \Illuminate\Http\Response
     */
    public function show(ContactQuery $contactQuery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactQuery  $contactQuery
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactQuery $contactQuery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactQuery  $contactQuery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactQuery $contactQuery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactQuery  $contactQuery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactQuery $contactQuery)
    {
        //
    }
}
