<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query =Category::where('status','!=','5');
        if($request->name !=""){
            $query = $query->where('category_name','LIKE','%'.$request->name.'%');
        }
        if($request->from_date !="" && $request->to_date !=""){
            $query = $query->whereDate('created_at','>=',$request->from_date)->whereDate('created_at','<=',$request->to_date);
        }
        $query = $query->orderBy('id','DESC')->get();
        $data['data'] =$query; 
        return view('admin/category/category_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/category/add_category');
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
            'title'=>'required',
            'image'=>'required',   
        ]);
        
        
      
        $model = new Category();
        if($request->hasfile('image')){
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
           
            $image->move(public_path('uploads/category_image'), $image_name);
            $model->image = "uploads/category_image/".$image_name;
        }
       
        $model->category_name = $request->post('title');
        $model->status = 1;
        $model->save();
        $request->session()->flash('message','Category added successfully.');
        return redirect('sysadmin/category-list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category,$id="")
    {
        if($id !=''){
            $result['data'] = Category::where(['id'=>$id])->first();
            return view('admin/category/edit_category',$result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'hiddenid'=>'required', 
            'hiddenfile'=>'required', 
        ]);
         if($request->post('hiddenid') > 0 ){
    
             $model = Category::find($request->post('hiddenid'));
             if($request->hasfile('image')){
                $image = $request->file('image');
                $ext = $image->extension();
                $image_name = time().'.'.$ext;
                $image->move(public_path('uploads/category_image'), $image_name);
                $model->image = "uploads/category_image/".$image_name;
            }else{
                $model->image = $request->post('hiddenfile');
            }
            
             $model->category_name = $request->post('title');
             $model->status = $request->post('status');
             $model->save();
             $request->session()->flash('message','Category Updated Successfully');
             return redirect('sysadmin/category-list');
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category,$id="")
    {
        if($id > 0  AND $id !=''){
    
            $model = Category::find($id);
            $model->status = 5;
            $model->save();
            $request->session()->flash('message','Category Deleted Successfully');
            return redirect('sysadmin/category-list');
        }
    }
}
