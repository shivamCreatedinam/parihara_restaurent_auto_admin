<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
date_default_timezone_set("Asia/Calcutta");
class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data'] = PrivacyPolicy::where(['id'=>1])->first();
        return view('admin/privacy_policy/edit_privacy_policy',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/privacy_policy/add_privacy_policy');
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
            'contents'=>'required',  
        ]);
        

        $model = new PrivacyPolicy();
        $model->contents = $request->post('contents');
        $model->created_date = date('Y-m-d');
        $model->created_time = date('h:i a');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Privacy Policy added successfully.');
        return redirect('sysadmin/privacy-policy');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(PrivacyPolicy $privacyPolicy,$id="")
    {
        if($id !=""){
            $result['data'] = PrivacyPolicy::where(['id'=>$id])->first();
            return view('admin/privacy_policy/edit_privacy_policy',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'contents'=>'required',  
        ]);
        
        if($request->post('hiddenid') > 0 ){
        $model = PrivacyPolicy::find($request->post('hiddenid'));
        $model->contents = $request->post('contents');
        $model->status = $request->post('status');
        $model->save();
        $request->session()->flash('message','Privacy Policy updated successfully.');
        return redirect('sysadmin/privacy-policy');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id="")
    {
        if($id > 0  AND $id !=''){
    
            $model = PrivacyPolicy::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Privacy Policy Deleted Successfully.');
            return redirect('sysadmin/privacy-policy');
        }
    }
}
