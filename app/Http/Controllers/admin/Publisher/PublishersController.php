<?php

namespace App\Http\Controllers\admin\Publisher;

use App\Http\Controllers\Controller;
use App\Models\PublishersModel;
use Illuminate\Http\Request;
use App\Http\Requests\Pulishers\PublisherRequest;
use Illuminate\Support\Facades\Storage;


class PublishersController extends Controller
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
        $publishers = PublishersModel::getAll($perPage, $filterCreateStart, $filterCreateEnd);
        return view('admin.publishers.index', compact('publishers'));
    }
    public function create()
    {
        return view('admin.publishers.create');
    }
    public function store(PublisherRequest $request)
    {

        try {
            if ($request->hasFile('logo')) {
                $file_image = $request->file('logo');
                $Pulisher = $request->publisher_name;
                $logo = PublishersModel::up_image_Pulisher($file_image, $Pulisher);
            } else {
                $logo = null;
            }
            $data = $request->except('_token');
            $data['logo'] = $logo;
            PublishersModel::create($data);
            return redirect()->route('publishers.index')->with('success', 'Thêm mới nhà xuất bản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm mới nhà xuất bản thất bại' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $publisher = PublishersModel::find($id);
        return view('admin.publishers.edit', compact('publisher'));
    }
    public function update(PublisherRequest $request, $id)
    {
        $publisher = PublishersModel::find($id);
        $data = $request->except('_token');
        try {
            if ($request->hasFile('logo')) {
                $file_image = $request->file('logo');
                $Pulisher = $request->publisher_name;
                $logo = PublishersModel::up_image_Pulisher($file_image, $Pulisher);
                $data['logo'] = $logo;
            } else {
                $data['logo'] = $publisher->logo;
            }

            $publisher->update($data);
            return redirect()->route('publishers.index')->with('success', 'Cập nhật nhà xuất bản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật nhà xuất bản thất bại, ' . $e->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            PublishersModel::find($id)->delete();
            return redirect()->route('publishers.index')->with('success', 'Xóa nhà xuất bản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát thất bại.');
        }
    }

    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = PublishersModel::find($list);
                    $song->delete();
                }
                return redirect()->route('publishers.index')->with('success', 'Xóa nhà xuất bản thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá bài hát thất bại!');
        }
    }

    public function search(Request $request)
    {
        $query = $request->search;
        $publishers = PublishersModel::search($query);
        return view('admin.publishers.index', compact('publishers'));
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
        $trashs = PublishersModel::getAlltrash($perPage, $filterCreateStart, $filterCreateEnd);

        return view('admin.publishers.trash', compact('trashs'));
    }

    public function search_trash_publishers(Request $request)
    {
        $query = $request->search;
        $trashs = PublishersModel::search_trash_publishers($query);
        return view('admin.publishers.trash', compact('trashs'));
    }

    public function restore_publishers($id)
    {
        $trash = PublishersModel::withTrashed()->find($id);
        $trash->restore();
        return redirect()->route('publishers.trash.index')->with('success', 'Khôi phục nhà xuất bản thành công');
    }

    public function restore_list_publishers(Request $request){
        $restorelist = json_decode($request->restore_list, true);
        if (is_array($restorelist)) {
           foreach ($restorelist as $restore){
             $trash = PublishersModel::withTrashed()->find($restore);
             $trash->restore();
           }
            return redirect()->route('publishers.trash.index')->with('success', 'Khôi phục tất cả nhà xuất bản thành công');
        } else {
            return redirect()->back()->with('error', 'Khôi phục tất cả nhà xuất bản thất bại!');
        }
    }

    public function destroy_publishers($id)
    {
        $trash = PublishersModel::withTrashed()->find($id);
        $trash->forceDelete();
        return redirect()->route('publishers.trash.index')->with('success', 'Xóa vĩnh viễn nhà xuất bản thành công');
    }

    public function restore_all_publishers()
    {
        PublishersModel::onlyTrashed()->restore();
        return redirect()->route('publishers.trash.index')->with('success', 'Khôi phục tất cả nhà xuất bản thành công');
    }

    public function destroy_list_publishers(Request $request)
    {
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            foreach ($deletelist as $list) {
                $trash = PublishersModel::withTrashed()->find($list);
                $trash->forceDelete();
            }
            return redirect()->route('publishers.trash.index')->with('success', 'Xóa vĩnh viễn tất cả nhà xuất bản thành công');
        } else {
            return redirect()->back()->with('error', 'Xoá tất cả nhà xuất bản thất bại!');
        }
    }



    // file logo

    public function file()
    {
        try {
            // Lấy tất cả các file trong folder 'song_image'
            $files = Storage::disk('s3')->files('Pulisher_logo');
            // Lấy danh sách ảnh từ bảng songs (music)
            $usedImages = PublishersModel::pluck('logo')->toArray();
            // Tạo danh sách ảnh kèm thông tin sử dụng
            $images = array_map(function ($file) use ($usedImages) {
                return [
                    'path'    => $file,
                    'url'     => Storage::disk('s3')->url($file),
                    'in_use'  => in_array(Storage::disk('s3')->url($file), $usedImages), // Kiểm tra ảnh có đang dùng
                ];
            }, $files);

            return view('admin.publishers.file', compact('images'));
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
