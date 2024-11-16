<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;


class CategoriesController extends Controller
{
    public function list_categories()
    {
        $categories = Category::paginate(10);
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
        $category = Category::where('categorie_name', $request->categorie_name)->first();
        if($category){
            return redirect()->back()->with('error','Tên thể loại đã tồn tại.');
        }

        try {
            Category::create($request->All());
            return redirect()->route('categories.list')->with('success','Thêm thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Thêm thể loại thất bại.'.$e);
        }
    }


    public function edit_categories($id){
        $category = Category::find($id);
        return view('admin.categories.edit-categories', compact('category'));
    }

    public function update_categories(Request $request, $id)
    {

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
            $category = Category::find($id);
            $category->update($request->all());
            return redirect()->route('categories.list')->with('success','Cập nhật thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thể loại thất bại.');
        }

    }

    public function delete_categories($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            return redirect()->route('categories.list')->with('success','Xóa thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Xóa thể loại thất bại.');
        }
    }

    public function delete_list(Request $request){
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $Country = Category::find($list);
                    $Country->delete();
                }
                return redirect()->route('categories.list')->with('success', 'Xoá thể loại thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa thể loại thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá thể loại thất bại!');
        }

    }
    public function search_categories(Request $request){
        $query = $request->search;
        $categories = Category::where('categorie_name', 'LIKE', '%'. $query. '%')->whereNull('deleted_at')->paginate(10);
        if($categories->isEmpty()) return redirect()->back()->with('error', 'Không tìm thấy kết quả cho tìm kiếm');

        Toastr()->success('Tìm thể loại thành công');
        return view('admin.categories.list-categories', compact('categories'));
    }


    // trash

    public function trash_categories(){
        $categories = Category::onlyTrashed()->paginate(10);
        return view('admin.categories.trash-categories', compact('categories'));
    }
    public function restore_categories($id){
        try {
            $category = Category::withTrashed()->find($id);
            $category->restore();
            return redirect()->back()->with('success','Phục hồi thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Phục hồi thể loại thất bại.');
        }

    }

    public function restore_list_categories(Request $request){
        $restorelist = json_decode($request->restore_list, true);
        if (is_array($restorelist)) {
            try {
                foreach ($restorelist as $list) {
                    $Country = Category::withTrashed()->find($list);
                    $Country->restore();
                }
                return redirect()->back()->with('success', 'Phục hồi thể loại thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Phục hồi thể loại thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Phục hồi thể loại thất bại!');
        }
    }

    public function restore_all_categories(){
        try {
            Category::withTrashed()->restore();
            return redirect()->back()->with('success','Phục hồi tất cả thể loại thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Phục hồi tất cả thể loại thất bại.');
        }
    }

    public function destroy_categories($id){
        try {
            $category = Category::withTrashed()->find($id);
            $category->forceDelete();
            return redirect()->back()->with('success','Xóa thể loại vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Xóa thể loại vĩnh viễn thất bại.');
        }
    }


    public function destroy_list_categories(Request $request){
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $Country = Category::withTrashed()->find($list);
                    $Country->forceDelete();
                }
                return redirect()->back()->with('success', 'Xóa thể loại vĩnh viễn thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa thể loại vĩnh viễn thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xóa thể loại vĩnh viễn thất bại!');
        }
    }
}
