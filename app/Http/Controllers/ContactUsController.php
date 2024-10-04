<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data'] = ContactUs::where(['id'=>1])->first();
        return view('admin/contact_us/edit_contact_us',$result);
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
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contactUs,$id="")
    {
        if($id !=""){
            $result['data'] = ContactUs::where(['id'=>$id])->first();
            return view('admin/contact_us/edit_contact_us',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'mobile'=>'required', 
            'email'=>'required', 
            'weeks'=>'required', 
            'times'=>'required', 
            'hiddenid'=>'required',  
        ]);
        if (filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)) {
            if($request->post('hiddenid') > 0 ){
                $model = ContactUs::find($request->post('hiddenid'));
                $model->mobile = $request->post('mobile');
                $model->email = $request->post('email');
                $model->weeks = $request->post('weeks');
                $model->times = $request->post('times');
                $model->status = $request->post('status');
                $model->save();
                $request->session()->flash('message','Contact Us updated successfully.');
                return redirect('sysadmin/contact-us');
                }
        }else{
            $request->session()->flash('error','Invalid email id.');
                return redirect('sysadmin/contact-us');
        }
        die;
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
