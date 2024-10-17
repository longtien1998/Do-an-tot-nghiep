<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function list_categories()
    {
        $categories = Categories::all();
        return view('admin.categories.list-categories', compact('categories'));
    }


    public function add_categories()
    {
        return view('admin.categories.add-categories');
    }

    public function store_categories(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'categorie_name' => 'required|string|max:255',
            'description' => 'required|max:255'
        ], [
            'categorie_name.required' => 'Tên thể loại không được để trống.',
            'categorie_name.max' => 'Tên thể loại quá dài.',

            'description.required' => 'Mô tả không được để trống.',
            'description.max' => 'Mô tả quá dài.'

        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        $category = Categories::where('categorie_name', $request->categorie_name)->first();
        if($category){
            return redirect()->back()->with('error','Tên thể loại đã tồn tại.');
        }

        try {
            Categories::create($request->All());
            return redirect()->route('list-categories')->with('success','Thêm thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Thêm thể loại thất bại.');
        }
    }

    public function update_categories(Request $request, $id)
    {
        $category = Categories::find($id);
        $validate = Validator::make($request->all(), [
            'categorie_name' =>'required|string|max:255',
            'description' =>'required|max:255'
        ],[
            'categorie_name.required' => 'Tên thể loại không được để trống.',
            'categorie_name.max' => 'Tên thể loại quá dài.',

            'description.required' => 'Mô tả không được để trống.',
            'description.max' => 'Mô tả quá dài.'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        try {
            $category->update($request->all());
            return redirect()->route('list-categories')->with('success','Cập nhật thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thể loại thất bại.');
        }

    }
    public function edit_categories($id){
        $category = Categories::find($id);
        return view('admin.categories.edit-categories', compact('category'));
    }

    public function delete_categories($id)
    {
        try {
            $category = Categories::find($id);
            $category->delete();
            return redirect()->route('list-categories')->with('success','Xóa thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Xóa thể loại thất bại.');
        }
    }
}
