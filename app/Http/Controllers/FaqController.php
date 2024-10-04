<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
date_default_timezone_set("Asia/Calcutta");
class FaqController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=Faq::where('status','!=','5');
        if($request->name !=""){
            $query = $query->where('questions','LIKE','%'.$request->name.'%')
            ->orWhere('answer','LIKE','%'.$request->name.'%');
            // $query = $query->orWhere('answer','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_date','>=',$request->from_date)->whereDate('created_date','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] =$query; 
        
        return view('admin/faq/faq_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/faq/add_faq');
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
            'questions'=>'required',  
            'answer'=>'required', 
        ]);
        
        
    
        $model = new Faq();
        $model->questions = $request->post('questions');
        $model->answer = $request->post('answer');
        $model->created_date = date('Y-m-d');
        $model->created_time = date('h:i a');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','FAQ added successfully.');
        return redirect('sysadmin/faq');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq,$id="")
    {
        if($id !=""){
            $result['data'] = Faq::where(['id'=>$id])->first();
            return view('admin/faq/edit_faq',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Faq $faq)
    {
        $request->validate([
            'questions'=>'required',  
            'answer'=>'required',
            'hiddenid'=>'required',
        ]);
        if($request->post('hiddenid') > 0 ){
        $model = Faq::find($request->post('hiddenid'));
        $model->questions = $request->post('questions');
        $model->answer = $request->post('answer');
        $model->status = $request->post('status');
        $model->save();
        $request->session()->flash('message','FAQ updated successfully.');
        return redirect('sysadmin/faq');
        
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , Faq $faq , $id="")
    {
        if($id > 0  AND $id !=''){
    
            $model = Faq::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','FAQ Deleted Successfully.');
            return redirect('sysadmin/faq');
        }
    }
}
