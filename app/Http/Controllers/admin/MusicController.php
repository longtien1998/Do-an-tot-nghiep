<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Response;
use App\Models\Music;
use App\Models\Categories;
use App\Http\Requests\MusicPostRequest;
use App\Models\Filepaths;



class MusicController extends Controller
{



    public function list_music()
    {
        // Music::onlyTrashed()->restore();
        $songs = Music::selectAll();
        return view('admin.music.list-music', compact('songs'));
    }




    public function add_music()
    {
        $Categories = Categories::all();
        return view('admin.music.add-music', compact('Categories'));
    }



    public function store_music(Request $request) //MusicPostRequest
    {
        // dd($request->all());

        try {
            if ($request->hasFile('song_image')) {

                // Lưu file vào S3
                $path_image = $request->file('song_image')->store('song_image', 's3');

                // Thiết lập quyền công khai cho file đã upload
                Storage::disk('s3')->setVisibility($path_image, 'public');

                // Lấy URL công khai của file
                $url_image = Storage::disk('s3')->url($path_image);
            } else {
                $url_image = null;
            }
            // Tạo mới bản ghi vào bảng songs
            $music = Music::create([
                'song_name' => $request->song_name,
                'description' => $request->description,
                'lyrics' => $request->lyrics,
                'singers_id' => $request->singers_id,
                'categories_id' => $request->categories_id,
                'release_date' => $request->release_date,
                'country' => $request->country,
                'provider' => $request->provider,
                'composer' => $request->composer,
                'song_image' => $url_image
            ]);

            $song_id = $music->id;

            // thêm đường dẫn nhạc basic
            if ($request->hasFile('file_basic')) {
                $path_basic = $request->file('file_basic')->store('music', 's3');
                Storage::disk('s3')->setVisibility($path_basic, 'public');
                $url_basic = Storage::disk('s3')->url($path_basic);

                Filepaths::create([
                    'file_path' => $url_basic,
                    'path_type' => 'Basic',
                    'song_id' => $song_id
                ]);
            }
            // thêm đường dẫn plus
            if ($request->hasFile('file_plus')) {
                $path_plus = $request->file('file_plus')->store('music', 's3');
                Storage::disk('s3')->setVisibility($path_plus, 'public');
                $url_plus = Storage::disk('s3')->url($path_plus);

                Filepaths::create([
                    'file_path' => $url_plus,
                    'path_type' => 'plus',
                    'song_id' => $song_id
                ]);
            }
            // thên đường dẫn premium
            if ($request->hasFile('file_premium')) {
                $path_premium = $request->file('file_premium')->store('music', 's3');
                Storage::disk('s3')->setVisibility($path_premium, 'public');
                $url_premium = Storage::disk('s3')->url($path_premium);

                Filepaths::create([
                    'file_path' => $url_premium,
                    'path_type' => 'premium',
                    'song_id' => $song_id
                ]);
            }

            return redirect()->route('list-music')->with('success', 'Thêm bài hát thành công');
        } catch (\Exception $e) {

            // Kiểm tra và xóa file dựa trên đường dẫn nội bộ (path_image)
            if (isset($path_image) && Storage::disk('s3')->exists($path_image)) {
                Storage::disk('s3')->delete($path_image);
            }
            if (isset($path_basic) && Storage::disk('s3')->exists($path_basic)) {
                Storage::disk('')->delete($path_basic);
            }
            if (isset($path_plus) && Storage::disk('s3')->exists($path_plus)) {
                Storage::disk('')->delete($path_plus);
            }
            if (isset($path_premium) && Storage::disk('s3')->exists($path_premium)) {
                Storage::disk('')->delete($path_premium);
            }


            return  redirect()->back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.' . $e);
        }
        // Upload file lên Amazon S3
        // $path = $request->file('music_file')->store('music', 's3');
        // Storage::disk('s3')->setVisibility($path, 'public');
        // $url = Storage::disk('s3')->url($path);



    }





    public function edit_music()
    {
        return view('admin.music.edit-music');
    }




    public function show_music($id)
    {
        $song = Music::show($id);
        dd($song);
        return view('admin.music.show-music');
    }






    public function update_music()
    {
        return view('admin.music.update-music');
    }




    public function delete_music($id)
    {
        try {
            Music::find($id)->delete();
            return redirect()->route('list-music')->with('success', 'Xoá bài hát thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát thất bại.');
        }
    }

    public function delete_list_music(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = Music::find($list);
                    $song->deleted_at = now();
                    $song->save();
                }
                return redirect()->route('list-music')->with('success', 'Xoá bài hát thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá bài hát thất bại!');
        }
    }




    public function list_trash_music()

    {
        $songs = Music::onlyTrashed()->get();
        // dd($songs);
        return view('admin.music.list-trash-music', compact('songs'));
    }



    public function restore_trash_music(Request $request)
    {
        // dd($request->restore_list);
        // Giải mã chuỗi JSON thành mảng
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Music::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục bài hát khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục bài hát khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Khôi phục bài hát khỏi thùng rác thất bại!');
        }
    }


    public function restore_all_music()
    {
        try {
            Music::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả bài hát khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục bài hát khỏi thùng rác thất bại.');
        }
    }

    public function delete_trash_music(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Music::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa bài hát khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Xóa bài hát khỏi thùng rác thất bại!');
        }
    }

    public function delete_all_music()
    {
        try {
            Music::withTrashed()->forceDelete();
            return redirect()->back()->with('success', 'Xóa tất cả bài hát khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát khỏi thùng rác thất bại.');
        }
    }


    public function destroy_trash_music($id)
    {
        try {
            Music::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('list-trash-music')->with('success', 'Xóa bài hát khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát khỏi thùng rác thất bại.');
        }
    }

    public function search_music()
    {
        return view('admin.music.search-music');
    }

    public function search_song_trash(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate);
        }
        try {
            $query = $request->search;
            $songs = Music::onlyTrashed()->where('song_name', 'LIKE', '%' . $query . '%')->get();
            if ($songs) {
                toastr()->success('Tìm bài hát thành công');
                return view('admin.music.list-trash-music', compact('songs'));
            } else {
                return redirect()->route('list-trash-music')->with('error', 'Không tìm thấy bài hát nào phù hợp với từ khóa');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy bài hát nào phù hợp với từ khóa.');
        }
    }
}
