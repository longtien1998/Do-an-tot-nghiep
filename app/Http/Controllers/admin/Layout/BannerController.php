<?php

namespace App\Http\Controllers\Admin\Layout;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class BannerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 20;
        $filterCreateStart = false;
        $filterCreateEnd = false;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
            $filterCreateStart = $request->input('filterCreateStart');
            $filterCreateEnd = $request->input('filterCreateEnd');
        }
        $banners = Banner::getAll($perPage, $filterCreateStart, $filterCreateEnd);
        return view('admin.settinglayout.banner.index', compact('banners'));
    }
    public function create()
    {
        return view('admin.settinglayout.banner.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'banner_name' => 'required|string|max:255',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:4056',

        ], [
            'banner_name.required' => 'Vui lòng nhập tên banner',
            'banner_name.string' => 'Tên banner phải là chuỗi',
            'banner_name.max' => 'Tên banner không quá 255 ký tự',
            'banner.image' => 'Vui lòng chọn hình ảnh',
            'banner.mimes' => 'Định dạng hình ảnh phải là jpeg, png, jpg, gif',
            'banner.max' => 'Kích thước hình ảnh không quá 4MB',
            'banner.required' => 'Vui lòng chọn hình ảnh',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }

        try {
            if ($request->hasFile('banner')) {
                $file_image = $request->file('banner');
                $banner_name = $request->banner_name;
                $url = Banner::up_Banner($file_image, $banner_name);
            } else {
                $url = null;
            }
            if ($request->has('status')) {
                Banner::where('status', '=', 1)->update(['status' => 0]);
            }
            Banner::create([
                'banner_name' => $request->banner_name,
                'banner_url' => $url,
                'status' => $request->has('status') ? 1 : 0,
            ]);
            return redirect()->route('banner.index')->with('success', 'Thêm mới banner thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm mới banner thất bại' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.settinglayout.banner.edit', compact('banner'));
    }
    public function update(Request $request, $id)
    {
        if ($request->has('status')) {
            Banner::where('status', '=', 1)->update(['status' => 0]);
        }
        $banner = Banner::findOrFail($id);
        $validate = Validator::make($request->all(), [
            'banner_name' => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4056',
        ], [
            'banner_name.required' => 'Vui lòng nhập tên banner',
            'banner_name.string' => 'Tên banner phải là chu',
            'banner_name.max' => 'Tên banner không quá 255 ký tự',
            'banner.image' => 'Vui lòng chọn hình ảnh',
            'banner.mimes' => 'Định dạng hình ảnh phải là jpeg, png, jpg, gif',
            'banner.max' => 'Kích thước hình ảnh không quá 4MB',
            'banner.required' => 'Vui lòng chọn hình ảnh',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        if ($request->hasFile('banner')) {
            $file_image = $request->file('banner');
            $banner_name = $request->banner_name;
            $url = Banner::up_banner($file_image, $banner_name);
            $banner->banner_url = $url;
        }
        $banner->banner_name = $request->banner_name;
        $banner->status = $request->status ? 1 : 0;
        if ($banner->save()) {
            return redirect()->route('banner.index')->with('success', 'Cập nhật banner thành công');
        } else {
            return redirect()->back()->with('error', 'Cập nhật banner thất bại');
        }
    }
    public function change_status($id){
        // dd($id);
        Banner::where('status', '=', 1)->update(['status' => 0]);
        $banner = Banner::findOrFail($id);

        $banner->status = 1;

        if($banner->save()){
            return response()->json([
                'message'=>'Thay đổi trạng thái banner thành công'
            ]);
        } else{
            return response()->json([
                'error'=>'Thay đổi trạng thái banner thất bại'
            ],409);
        }
    }

    public function delete($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            if($banner->status == 1 ){
                return redirect()->back()->with('error', 'Không thể xóa banner đang đang hiển thị.');
            }
            $banner->delete();
            return redirect()->route('banner.index')->with('success', 'Xóa banner thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa banner thất bại.');
        }
    }

    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = Banner::findOrFail($list);
                    if($song->status == 1 ){
                        return redirect()->back()->with('error', 'Không thể xóa banner đang hiển thị.');
                    }
                    $song->delete();
                }
                return redirect()->route('banner.index')->with('success', 'Xóa banner thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa banner thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá banner thất bại!');
        }
    }

    public function search(Request $request)
    {
        $query = $request->search;
        $banners = Banner::search($query);
        return view('admin.banner.index', compact('banners'));
    }


    // trash
    public function trash(Request $request)
    {
        $perPage = 10;
        $filterCreateStart = false;
        $filterCreateEnd = false;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
            $filterCreateStart = $request->input('filterCreateStart');
            $filterCreateEnd = $request->input('filterCreateEnd');
        }
        $trashs = Banner::getAlltrash($perPage, $filterCreateStart, $filterCreateEnd);

        return view('admin.settinglayout.banner.trash', compact('trashs'));
    }

    public function search_trash_banner(Request $request)
    {
        $query = $request->search;
        $trashs = Banner::search_trash_banner($query);
        return view('admin.settinglayout.banner.trash', compact('trashs'));
    }

    public function restore_banner($id)
    {
        $trash = Banner::withTrashed()->find($id);
        $trash->restore();
        return redirect()->route('banner.trash.index')->with('success', 'Khôi phục banner thành công');
    }

    public function restore_list_banner(Request $request)
    {
        $restorelist = json_decode($request->restore_list, true);
        if (is_array($restorelist)) {
            foreach ($restorelist as $restore) {
                $trash = Banner::withTrashed()->find($restore);
                $trash->restore();
            }
            return redirect()->route('banner.trash.index')->with('success', 'Khôi phục tất cả banner thành công');
        } else {
            return redirect()->back()->with('error', 'Khôi phục tất cả banner thất bại!');
        }
    }

    public function destroy_banner($id)
    {
        $trash = Banner::withTrashed()->find($id);
        $trash->forceDelete();
        return redirect()->route('banner.trash.index')->with('success', 'Xóa vĩnh viễn banner thành công');
    }

    public function restore_all_banner()
    {
        Banner::onlyTrashed()->restore();
        return redirect()->route('banner.trash.index')->with('success', 'Khôi phục tất cả banner thành công');
    }

    public function destroy_list_banner(Request $request)
    {
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            foreach ($deletelist as $list) {
                $trash = Banner::withTrashed()->find($list);
                $trash->forceDelete();
            }
            return redirect()->route('banner.trash.index')->with('success', 'Xóa vĩnh viễn tất cả banner thành công');
        } else {
            return redirect()->back()->with('error', 'Xoá tất cả banner thất bại!');
        }
    }



    // file jmage

    public function file()
    {
        try {

            $images = Banner::getImage();
            return view('admin.settinglayout.banner.file', compact('images'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách file: ' . $e->getMessage());
        }
    }

    // Xóa file ảnh trên S3
    public function destroy_file(Request $request)
    {
        try {
            if (Storage::disk('s3')->exists($request->path)) {
                Storage::disk('s3')->delete($request->path);
                return redirect()->back()->with('success', 'Xóa file thành công.');
            } else {
                return redirect()->back()->with('error', 'File không tồn tại.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi xóa file: ' . $e->getMessage());
        }
    }

    public function list_destroy_file(request $request)
    {

        $list_destroy_songs = json_decode($request->delete_list, true);
        // dd($list_destroy_songs);
        try {
            foreach ($list_destroy_songs as $file_path) {
                Storage::disk('s3')->delete($file_path);
            }
            return redirect()->back()->with('success', 'Xóa tất cả file thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa tất cả file thất bại' . $e->getMessage());
        }
    }
}
