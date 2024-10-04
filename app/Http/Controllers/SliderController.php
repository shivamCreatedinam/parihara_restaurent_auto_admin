<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data']=Slider::where('status','!=','5')->where('slider_type','Slider')->orderBy('id','DESC')->get();
        $data['banner']=Slider::where('status','!=','5')->where('slider_type','Banner')->orderBy('id','DESC')->get();
        return view('admin/slider/slider_list',$data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/slider/add_slider');
    }

    public function banner_create()
    {
        return view('admin/slider/add_banner');
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
            // 'title'=>'required',
            'image'=>'required', 
            'slider_type'=> 'required',
        ]);
        
        $model = new Slider();
        if($request->hasfile('image')){
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
            // $image->storeAs('/public/uploads/slider_image',$image_name);
            $image->move(public_path('uploads/slider_image'), $image_name);
            $model->image = "uploads/slider_image/".$image_name;
        }
       
        $model->title = $request->post('title');
        $model->slider_type = $request->post('slider_type');
        $model->status = 1;
        $model->save();
        if($request->post('slider_type') == 'Banner'){
            $request->session()->flash('message','Banner added Successfully');
        }else{
            $request->session()->flash('message','Slider added Successfully');
        }
        
        return redirect('sysadmin/slider-list');
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider,$id="")
    {
        if($id !=''){
            $result['data'] = Slider::where(['id'=>$id])->first();
            return view('admin/slider/edit_slider',$result);
        }
       
    }
    public function banner_show(Slider $slider,$id="")
    {
        if($id !=''){
            $result['data'] = Slider::where(['id'=>$id])->first();
            return view('admin/slider/edit_banner',$result);
        }
       
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            // 'title'=>'required',
            'hiddenid'=>'required', 
            'hiddenfile'=>'required',
            'slider_type'=>'required', 
        ]);
         if($request->post('hiddenid') > 0 ){
    
             $model = Slider::find($request->post('hiddenid'));
             if($request->hasfile('image')){
                $image = $request->file('image');
                $ext = $image->extension();
                $image_name = time().'.'.$ext;
                $image->move(public_path('uploads/slider_image'), $image_name);
                $model->image = "uploads/slider_image/".$image_name;
            }else{
                $model->image = $request->post('hiddenfile');
            }
            
             $model->title = $request->post('title');
             $model->status = $request->post('status');
             $model->save();
             if($request->post('title') == 'Banner'){
                $request->session()->flash('message','Banner Updated Successfully');
             }else{
                $request->session()->flash('message','Slider Updated Successfully');
             }
             
             return redirect('sysadmin/slider-list');
         }
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id="")
    {
        if($id > 0  AND $id !=''){
    
            $model = Slider::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Slider Deleted Successfully');
            return redirect('sysadmin/slider-list');
        }
   
    }

    public function banner_destroy(Request $request,$id="")
    {
        if($id > 0  AND $id !=''){
    
            $model = Slider::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Banner Deleted Successfully');
            return redirect('sysadmin/slider-list');
        }
   
    }
}
