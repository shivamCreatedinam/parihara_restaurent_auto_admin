<?php

namespace App\Http\Controllers;

use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data'] = TermsAndCondition::where(['id'=>1])->first();
        return view('admin/t_a_c/edit_t_a_c',$result);
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
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function show(TermsAndCondition $termsAndCondition,$id="")
    {
        if($id !=""){
            $result['data'] = TermsAndCondition::where(['id'=>$id])->first();
            return view('admin/t_a_c/edit_t_a_c',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'contents'=>'required', 
            'hiddenid'=>'required',  
        ]);
        
        if($request->post('hiddenid') > 0 ){
        $model = TermsAndCondition::find($request->post('hiddenid'));
        $model->contents = $request->post('contents');
        $model->status = $request->post('status');
        $model->save();
        $request->session()->flash('message','Terms And Conditions updated successfully.');
        return redirect('sysadmin/terms-and-conditions');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TermsAndCondition $termsAndCondition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermsAndCondition $termsAndCondition)
    {
        //
    }
}
