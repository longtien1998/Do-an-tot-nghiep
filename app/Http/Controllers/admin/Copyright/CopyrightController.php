<?php

namespace App\Http\Controllers\Admin\Copyright;

use App\Http\Controllers\Controller;
use App\Models\Copyright;
use App\Models\Music;
use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Requests\CopyrightRequest;
use Illuminate\Support\Facades\Storage;


class CopyrightController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $filterCreateStart = false;
        $filterCreateEnd = false;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
            $filterCreateStart = $request->input('filterCreateStart');
            $filterCreateEnd = $request->input('filterCreateEnd');
        }
        $copyrights = Copyright::getAll($perPage, $filterCreateStart, $filterCreateEnd);
        // dd($copyrights[2]->expiry_day->format('d-m-Y'));
        return view('admin.copyright.index', compact('copyrights'));
    }

    public function create()
    {
        $songs = Music::select('id', 'song_name')->get();
        $publishers = Publisher::select('id', 'publisher_name')->get();
        return view('admin.copyright.create', compact('songs', 'publishers'));
    }
    public function store(CopyrightRequest $request)
    {
        // dd($request->all());
        if ($request->hasFile('license_file')) {
            $file = $request->file('license_file');
            $type = true;
            $licenseFile = Copyright::file_copyright($file, $type);
        } else if ($request->input('text')) {
            $file = $request->input('text');
            $type = false;
            $licenseFile = Copyright::file_copyright($file, $type);
        } else {
            $licenseFile = null;
        }

        try {
            // dd($request->all());
            Copyright::create([
                'song_id' => $request->song_id,
                'publisher_id' => $request->publisher_id,
                'license_type' => $request->license_type,
                'issue_day' => $request->issue_day,
                'expiry_day' => $request->expiry_day,
                'usage_rights' => $request->usage_rights,
                'terms' => $request->terms,
                'price' => $request->price,
                'payment' => $request->payment,
                'location' => $request->location,
                'pay_day' => $request->pay_day,
                'license_file' => $licenseFile,
            ]);

            return redirect()->route('copyrights.index')->with('success', 'Thêm bản quyền thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm bản quyền thất bại.');
        }
    }

    public function edit($id)
    {
        $copyright = Copyright::find($id);

        $songs = Music::select('id', 'song_name')->get();
        $publishers = Publisher::select('id', 'publisher_name')->get();
        return view('admin.copyright.edit', compact('songs', 'publishers', 'copyright'));
    }
    public function update(CopyrightRequest $request, $id)
    {
        $copyright = Copyright::find($id);

        if ($request->hasFile('license_file')) {
            $file = $request->file('license_file');
            $type = true;
            $licenseFile = Copyright::file_copyright($file, $type);
        } else if ($request->input('text')) {
            $file = $request->input('text');
            $type = false;
            $licenseFile = Copyright::file_copyright($file, $type);
        } else {
            $licenseFile = $copyright->license_file;
        }
        try {
            $copyright->update([
                'song_id' => $request->song_id,
                'publisher_id' => $request->publisher_id,
                'license_type' => $request->license_type,
                'issue_day' => $request->issue_day,
                'expiry_day' => $request->expiry_day,
                'usage_rights' => $request->usage_rights,
                'terms' => $request->terms,
                'price' => $request->price,
                'payment' => $request->payment,
                'location' => $request->location,
                'pay_day' => $request->pay_day,
                'license_file' => $licenseFile,
            ]);

            return redirect()->route('copyrights.index')->with('success', 'Cập nhật bản quyền thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật bản quyền thất bại.');
        }
    }
    public function delete($id)
    {
        try {
            $copyright = Copyright::find($id);
            $copyright->delete();
            return redirect()->route('copyrights.index')->with('success', 'Xóa bản quyền thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa bản quyền thất bại.');
        }
    }
    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $copyright = copyright::find($list);
                    $copyright->delete();
                }
                return redirect()->route('copyrights.index')->with('success', 'Xóa bản quyền thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bản quyền thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá bản quyền thất bại!');
        }
    }
    public function search(Request $request) {
        $search = $request->search;
        $copyrights = Copyright::search($search);

        return view('admin.copyright.index', compact('copyrights'));
    }


    // trash
    public function trash(Request $request){
        $perPage = 10;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
        }
        $copyrights = Copyright::getAllTrash($perPage);
        $trashes = Copyright::onlyTrashed()->paginate(10);
        return view('admin.copyright.trash', compact('trashes'));
    }
    public function restore_copyrights($id){
        try{
            $copyright = Copyright::withTrashed()->where('id', $id)->first();
            $copyright->restore();
            return redirect()->route('copyrights.trash.index')->with('success', 'Khôi phục bản quyền thành công');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục bản quyền thất bại.');
        }
    }
    public function restore_list_copyrights(Request $request){
        // dd($request->restore_list);
        $restorelist = json_decode($request->restore_list, true);
        if(is_array($restorelist)){
            try{
                foreach($restorelist as $list){
                    $copyright = Copyright::withTrashed()->where('id', $list)->first();
                    $copyright->restore();
                }
                return redirect()->route('copyrights.trash.index')->with('success', 'Khôi phục bản quyền thành công');

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Khôi phục bản quyền thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Khôi phục bản quyền thất bại!');
        }
    }
    public function restore_all_copyrights(){
        try{
            Copyright::withTrashed()->restore();
            return redirect()->route('copyrights.trash.index')->with('success', 'Khôi phục tất cả bản quyền thành công');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục tất cả bản quyền thất bại.');
        }
    }
    public function destroy_copyrights($id){
        try{
            $copyright = Copyright::withTrashed()->where('id', $id)->first();
            $copyright->forceDelete();
            return redirect()->route('copyrights.trash.index')->with('success', 'Xóa vĩnh viễn bản quyền thành công');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn bản quyền thất bại.');
        }
    }

    public function destroy_list_copyrights(Request $request){
        // dd($request->destroy_list);
        $deletelist = json_decode($request->delete_list, true);
        if(is_array($deletelist)){
            try{
                foreach($deletelist as $list){
                    $copyright = Copyright::withTrashed()->where('id', $list)->first();
                    $copyright->forceDelete();
                }
                return redirect()->route('copyrights.trash.index')->with('success', 'Xóa vĩnh viễn bản quyền thành công');

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Xóa vĩnh viễn bản quyền thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn bản quyền thất bại!');
        }
    }

    public function search_trash_copyrights(Request $request){
        $search = $request->search;
        $trashes = Copyright::searchTrash($search);

        return view('admin.copyright.trash', compact('trashes'));

    }


    // file bản quyền

    public function file()
    {
        try {

            $filescopyright = Copyright::Checkfile();


            return view('admin.copyright.file', compact('filescopyright'));
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

    public function list_destroy_file(request $request){

        $list_destroy_songs = json_decode($request->delete_list, true);
        // dd($list_destroy_songs);
        try{
            foreach ($list_destroy_songs as $file_path) {
                Storage::disk('s3')->delete($file_path);
            }
            return redirect()->back()->with('success','Xóa tất cả file thành công');

        } catch (\Exception $e) {
            return redirect()->back()->with('error','Xóa tất cả file thất bại' . $e->getMessage());
        }
    }
}
