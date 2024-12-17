<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::paginate(10);
        // dd($countries);
        return view('admin.music.country.country', compact('countries'));
    }

    public function store_country(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(),[
            'name_country' => 'required|string|unique:country,name_country',
            'background' => 'required',
        ],[
            'name_country.required' => 'Tên quốc gia không được để trống.',
            'name_country.string' => 'Tên quốc gia phải là chuỗi ký tự',
            'background.required' => 'Hình nền không được để trống.',
            'name_country.unique' => 'Tên quốc gia đã tồn tại.',
        ]);
        if($validate->fails()) {
            // dd($validate);
            // Toastr()->error($validate->messages());
            return redirect()->back()->withErrors($validate);
        }
        try{
            if($request->hasFile('background')){
                $file = $request->file('background');
                $name = $request->name_country;
                $url_image = Country::up_image($file, $name);
            } else {
                $url_image = null;
            }

            Country::create([
                'name_country' => $request->name_country,
                'background' => $url_image,
            ]);
            return redirect()->route('list-country')->with('success', 'Thêm mới quốc gia thành công.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm mới quốc gia thất bại.');
        }
    }

    public function edit_country($id){
        $country = Country::find($id);
        return view('admin.music.country.edit', compact('country'));
    }

    public function update_country(Request $request, $id){
        // dd($request->all());
        $validate = Validator::make($request->all(),[
            'name_country' => 'required|string|unique:country,name_country,'.$id,
        ],[
            'name_country.required' => 'Tên quốc gia không được để trống.',
            'name_country.string' => 'Tên quốc gia phải là chuỗi ký tự',
            'name_country.unique' => 'Tên quốc gia đã tồn tại.',
        ]);
        if($validate->fails()) {
            // dd($validate);
            // Toastr()->error($validate->messages());
            return redirect()->back()->withErrors($validate);
        }

        try{
            if($request->hasFile('background')){
                $file = $request->file('background');
                $name = $request->name_country;
                $url_image = Country::up_image($file, $name);
            } else {
                $url_image = Country::find($id)->background;
            }
            Country::find($id)->update([
                'name_country' => $request->name_country,
                'background' => $url_image,
            ]);
            return redirect()->route('list-country')->with('success', 'Cập nhật quốc gia thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật quốc gia thất bại.');
        }
    }

    public function delete_country($id){
        try{
            Country::find($id)->delete();
            return redirect()->route('list-country')->with('success', 'Xóa quốc gia thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa quốc gia thất bại. Quốc gia đang có bản ghi liên quan.');
        }
    }

    public function delete_list_country(Request $request){
        $deletelist = json_decode($request->delete_list, true);

        if (is_array($deletelist)) {

            try {
                foreach ($deletelist as $list) {
                    $Country = Country::find($list);
                    $Country->delete();
                }
                return redirect()->route('list-country')->with('success', 'Xoá Quốc gia thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa Quốc gia thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá Quốc gia thất bại!');
        }
    }

    public function search_country(Request $request){
        $search = $request->search;
        $countries = Country::where('name_country', 'like', '%'.$search.'%')->paginate(10);
        toastr()->success('Tìm quốc gia thành công');
        return view('admin.music.country.country', compact('countries'));
    }



    //trash
    public function list_trash_country()

    {
        $Countries = Country::onlyTrashed()->paginate(10);
        // dd($songs);
        return view('admin.music.country.trash-country', compact('Countries'));
    }

    public function restore_country($id){
        try{
            Country::withTrashed()->find($id)->restore();
            return redirect()->back()->with('success', 'Khôi phục quốc gia thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục quốc gia thất bại.');
        }
    }

    public function restore_trash_country(Request $request){
        $restore_list = json_decode($request->restore_list, true);
        if (is_array($restore_list)) {
            try {
                foreach ($restore_list as $list) {
                    Country::withTrashed()->find($list)->restore();
                }
                return redirect()->back()->with('success', 'Khôi phục Quốc gia thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục Quốc gia thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Khôi phục Quốc gia thất bại!');
        }

    }

    public function restore_all_country(){
        try{
            Country::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả quốc gia thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục tất cả Quốc gia thất bại.');
        }
    }

    public function destroy_trash_list_country(request $request){
        $delete_list = json_decode($request->delete_list, true);

        if (is_array($delete_list)) {
            try {
                foreach ($delete_list as $list) {
                    Country::withTrashed()->find($list)->forceDelete();
                }
                return redirect()->back()->with('success', 'Xóa vĩnh viễn quốc gia thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa vĩnh viễn Quốc gia thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn Quốc gia thất bại!');
        }
    }

    public function destroy_trash_country($id){
        try{
            Country::withTrashed()->find($id)->forceDelete();
            return redirect()->back()->with('success', 'Xóa vĩnh viễn quốc gia thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn quốc gia thất bại.');
        }
    }
}
