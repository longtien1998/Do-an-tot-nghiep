<?php

namespace App\Http\Controllers\Admin\Album;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\AlbumSongs;
use App\Models\Singer;
use App\Models\Music;
use App\Http\Requests\AlbumRequest;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller

{
    public function list_album()
    {
        // Lấy dữ liệu album với ca sĩ và bài hát, phân trang
        $albums = Album::with(['singer', 'songs'])->paginate(10);
        return view('admin.album.list-album', compact('albums'));
    }

    //View list album_song
    public function list_album_song()
    {
        $albums = Album::all();
        $songs = Music::all();
        $albumsong = AlbumSongs::paginate(10);
        return view('admin.album.list-album_song', compact('albums', 'songs', 'albumsong'));
    }
    public function index()
    {
        $albums = Album::with('singer')->paginate(10); // Tải quan hệ singer
        return view('admin.albums.list', compact('albums'));
    }

    // public function showAlbumsWithAllSongs($singerId)
    // {
    //     // Lấy thông tin ca sĩ
    //     $singer = Singer::findOrFail($singerId);

    //     // Lấy danh sách album thuộc ca sĩ
    //     $albums = Album::with('songs')->where('singer_id', $singerId)->get();

    //     // Lấy tất cả bài hát từ các album (không giới hạn bởi ca sĩ)
    //     $allSongs = [];
    //     foreach ($albums as $album) {
    //         foreach ($album->songs as $song) {
    //             $allSongs[] = $song;
    //         }
    //     }

    //     return view('admin.album.show-albums-with-all-songs', compact('singer', 'albums', 'allSongs'));
    // }


    public function add_album()
    {
        $singers = Singer::all();
        return view('admin.album.add-album', compact('singers'));
    }

    public function store_album(AlbumRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = $request->album_name;
                $image = Album::up_file_album($image, $name);
            } else {
                $image = '';
            }
            Album::create([
                'album_name' => $request->album_name,
                'singer_id' => $request->singer_id,
                'image' => $image,
            ]);
            return redirect()->route('albums.list')->with('success', 'Thêm album thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm album thất bại.' . $e->getMessage());
        }
    }


    public function edit_album($id)
    {
        $album = Album::findOrFail($id);
        $singers = Singer::all();
        // dd($album);
        return view('admin.album.edit-album', compact('album', 'singers'));
    }

    public function update_album(Request $request, $id)
    {
        // dd($request->all());
        $request->validate(
            [
                'album_name' => 'required|string|max:255',
                'singer_id' => 'required|integer',
                'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'album_name.required' => 'Tên album không được để trống',
                'album_name.string' => 'Tên album phải là chuỗi',
                'album_name.max' => 'Tên album không được quá 255 ký tự',
                'singer_id.required' => 'Bạn chưa chọn ca sĩ',
                'image.file' => 'Hình ảnh không được để trống',
                'image.mimes' => 'Hình ảnh phải là file .jpeg, .png,
                .jpg',
                'image.max' => 'Hình ảnh không được quá 2MB',
            ]
        );
        $data = [
            'album_name' => $request->album_name,
            'singer_id' => $request->singer_id,
        ];
        if ($request->hasFile('image')) {
            $data['image'] = Album::up_file_album($request->file('image'), $request->album_name);
        }
        Album::updateAlbum($id, $data);
        return redirect()->route('albums.list')->with('success', 'Cập nhật album thành công!');
    }

    public function delete_album($id)
    {
        try {
            $album = Album::find($id);
            $album->delete();
            return redirect()->route('albums.list')->with('success', 'Xóa album thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa album thất bại.');
        }
    }


    public function delete_list(Request $request)
    {
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $album = Album::find($list);
                    $album->delete();
                }
                return redirect()->route('albums.list')->with('success', 'Xoá album thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa album thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá album thất bại!');
        }
    }

    //search

    public function search_album(Request $request)
    {
        $query = $request->search;

        // Lấy dữ liệu album
        $albums = Album::where('album_name', 'LIKE', '%' . $query . '%')->whereNull('deleted_at')->paginate(10);

        // Kiểm tra kết quả
        if ($albums->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy kết quả cho tìm kiếm');
        }

        // Nếu có kết quả
        Toastr()->success('Tìm album thành công');
        return view('admin.album.list-album', compact('albums'));
    }

    //trash

    public function list_trash_album()

    {
        $albums = Album::onlyTrashed()->paginate(10);
        return view('admin.album.trash-album', compact('albums'));
    }


    public function restore_trash_album(Request $request)
    {

        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Album::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục album thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục album thành công!');
        } else {
            return redirect()->back()->with('error', 'Khôi phục album thất bại!');
        }
    }

    public function delete_trash_album(Request $request)
    {
        $delete_list = json_decode($request->delete_list, true);
        if (is_array($delete_list)) {
            try {
                foreach ($delete_list as $id) {
                    Album::withTrashed()->find($id)->forceDelete();
                }
                return redirect()->back()->with('success', 'Xóa album thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa album thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Danh sách cần xóa không hợp lệ.');
        }
    }


    public function restore_all_album()
    {
        try {
            Album::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả album thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục tất cả album thất bại.');
        }
    }

    public function destroy_trash_list_album(request $request)
    {
        $delete_list = json_decode($request->delete_list, true);

        if (is_array($delete_list)) {
            try {
                foreach ($delete_list as $list) {
                    Album::withTrashed()->find($list)->forceDelete();
                }
                return redirect()->back()->with('success', 'Xóa vĩnh viễn album thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa vĩnh viễn album thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn album thất bại!');
        }
    }

    public function destroy_trash_album($id)
    {
        try {
            Album::withTrashed()->find($id)->forceDelete();
            return redirect()->back()->with('success', 'Xóa vĩnh viễn album thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn album thất bại.');
        }
    }

    //search trash

    public function search_album_trash(Request $request)
    {
        // Validate input
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);

        if ($validate->fails()) {
            // Trả về thông báo lỗi nếu validation thất bại
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            // Tìm kiếm album trong trash
            $query = $request->search;
            $albums = Album::onlyTrashed()
                ->where('album_name', 'LIKE', '%' . $query . '%')
                ->paginate(10);

            // Kiểm tra kết quả tìm kiếm
            if ($albums->isEmpty()) {
                return redirect()->route('albums.trash.list')
                    ->with('error', 'Không tìm thấy album nào phù hợp với từ khóa');
            }

            // Nếu tìm thấy, trả về view
            toastr()->success('Tìm album thành công');
            return view('admin.album.trash-album', compact('albums'));
        } catch (\Exception $e) {
            // Xử lý lỗi ngoại lệ
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
}
