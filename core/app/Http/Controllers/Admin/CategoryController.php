<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pageTitle = 'Category List';
        $emptyMessage = 'No category available.';
        $categories=Category::latest()->paginate(getPaginate(10));
        return view('admin.category.index',compact('pageTitle','emptyMessage','categories'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);

        $category=new Category();
        $category->name=$request->name;
        $category->save();
        $notify=['success','Category create successfully'];
        return back()->withNotify($notify);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category=Category::findOrFail($id);
        $category->name=$request->name;
        $category->save();
        $notify=['success','Category update successfully'];
        return back()->withNotify($notify);
    }


    public function changeStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->status = !$category->status;
        $category->save();
        $notify[] = ['success', 'Category Status Change Succeessfully'];
        return back()->withNotify($notify);
    }
}
