<?php

namespace App\Http\Controllers\admin\music;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Response;
use App\Models\Music;
use App\Models\Categories;
use App\Models\Country;
use App\Http\Requests\Music\MusicPostRequest;
use App\Http\Requests\Music\MusicUpdateRequest;
use App\Models\Filepaths;
use App\Models\Singer;
use Faker\Core\File;

class MusicController extends Controller
{



    public function list_music(Request $request)
    {


        $perPage = 10;
        $filterTheloai = false;
        $filterSinger = false;
        $filterRelease = false;
        $filterCreate = false;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
            $filterTheloai = $request->input('filterTheloai');
            $filterSinger = $request->input('filterSinger');
            $filterRelease = $request->input('filterRelease');
            $filterCreate = $request->input('filterCreate');
        }

        // Music::onlyTrashed()->restore();
        // Số lượng bản ghi mỗi trang
        $songs = Music::selectAll($perPage, $filterTheloai, $filterSinger, $filterRelease, $filterCreate);
        return view('admin.music.song.list-music', compact('songs'));
    }

    public function search_song(Request $request)
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
            $songs = Music::search_songs($query);
            if ($songs->isEmpty()) {
                return redirect()->route('list-music')->with('error', 'Không tìm thấy bài hát nào phù hợp với từ khóa');
            } else {
                toastr()->success('Tìm bài hát thành công');
                return view('admin.music.song.list-music', compact('songs'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy bài hát nào phù hợp với từ khóa.');
        }
    }


    public function add_music()
    {
        $Categories = Categories::all();
        $Countries = Country::all();
        $Singers = Singer::all();
        return view('admin.music.song.add-music', compact('Categories', 'Countries', 'Singers'));
    }



    public function store_music(MusicPostRequest $request) //MusicPostRequest
    {
        // dd($request->all());

        try {
            if ($request->hasFile('song_image')) {
                $file_image = $request->file('song_image');
                $songName = $request->song_name;
                $url_image = Music::up_image_song($file_image, $songName);
            } else {
                $url_image = null;
            }
            // Tạo mới bản ghi vào bảng songs
            $music = Music::create([
                'song_name' => $request->song_name,
                'description' => $request->description,
                'lyrics' => $request->lyrics,
                'singer_id' => $request->singer_id,
                'category_id' => $request->category_id,
                'release_day' => $request->release_day,
                'country_id' => $request->country_id,
                'provider' => $request->provider,
                'composer' => $request->composer,
                'song_image' => $url_image
            ]);

            $song_id = $music->id;
            // dd($song_id);

            // thêm đường dẫn nhạc basic
            if ($request->hasFile('file_basic')) {

                $file = $request->file('file_basic');
                $songName = $request->song_name;
                $quality = '128kbps';
                $url_basic = Music::up_file_song($file, $songName, $quality);
                Filepaths::create([
                    'file_path' => $url_basic,
                    'path_type' => 'Basic',
                    'song_id' => $song_id
                ]);
            }
            // thêm đường dẫn plus
            if ($request->hasFile('file_plus')) {
                $file = $request->file('file_plus');
                $songName = $request->song_name;
                $quality = '320kbps';
                $url_plus = Music::up_file_song($file, $songName, $quality);

                Filepaths::create([
                    'file_path' => $url_plus,
                    'path_type' => 'plus',
                    'song_id' => $song_id
                ]);
            }
            // thên đường dẫn premium
            if ($request->hasFile('file_premium')) {
                $file = $request->file('file_premium');
                $songName = $request->song_name;
                $quality = 'lossless';
                $url_premium = Music::up_file_song($file, $songName, $quality);


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



    public function show_music($id)
    {
        $song = Music::show($id);
        $Categories = Categories::all();
        $Countries = Country::all();
        $Singers = Singer::all();
        // dd($song);
        return view('admin.music.song.show-music', compact('song', 'Categories', 'Countries', 'Singers'));
    }



    public function update_music(MusicUpdateRequest $request, $id)
    {
        $song = Music::find($id);
        if(!$song){
            return redirect()->back()->with('error', 'Không tìm thấy bài hát để cập nhật.');
        }
        $count = Music::where('song_name', '=', $request->song_name)->count();
        if ($count > 1 ) {
            return redirect()->back()->with('error', 'Tên bài hát đã tồn tại. Vui lòng chọn tên khác.');
        }
        try {
            $song->song_name = $request->song_name;
            $song->description = $request->description;
            $song->lyrics = $request->lyrics;
            $song->singer_id = $request->singer_id;
            $song->category_id = $request->category_id;
            $song->release_day = $request->release_day;
            $song->country_id = $request->country_id;
            $song->provider = $request->provider;
            $song->composer = $request->composer;
            if ($request->hasFile('song_image')) {
                $file_image = $request->file('song_image');
                $songName = $request->song_name;
                $url_image = Music::up_image_song($file_image, $songName);
                $song->song_image = $url_image;
            }
            $song->save();
            return redirect()->back()->with('success','Cập nhật bài hát thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.' . $e);
        }

        // dd($request->all(), $song);


    }



    public function up_loadFile_music(Request $request, $id)
    {
        if ($request->file_basic_up == null && $request->file_plus_up == null && $request->file_premium_up == null) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 file nhạc để upload.');
        }

        try {


            $song = Music::find($id);

            // thêm đường dẫn nhạc basic
            if ($request->hasFile('file_basic_up')) {

                $file = $request->file('file_basic_up');
                $songName = $song->song_name;
                $quality = '128kbps';
                $url_basic = Music::up_file_song($file, $songName, $quality);

                $path = Filepaths::where('song_id', '=', $id)->where('path_type', '=', 'basic')->first();
                if ($path != null) {
                    $path->update(['file_path' =>  $url_basic]);
                } else {
                    Filepaths::Create([
                        'file_path' => $url_basic,
                        'path_type' => 'basic',
                        'song_id' => $id
                    ]);
                }
            }
            // thêm đường dẫn plus
            if ($request->hasFile('file_plus_up')) {
                $file = $request->file('file_plus_up');
                $songName = $song->song_name;

                $quality = '320kbps';
                $url_plus = Music::up_file_song($file, $songName, $quality);
                // dd($url_plus);
                $path = Filepaths::where('song_id', '=', $id)->where('path_type', '=', 'plus')->first();
                // dd($path);
                if ($path != null) {
                    $path->update(['file_path' =>  $url_plus]);
                } else {
                    Filepaths::Create([
                        'file_path' => $url_plus,
                        'path_type' => 'plus',
                        'song_id' => $id
                    ]);
                }
            }
            // thên đường dẫn premium
            if ($request->hasFile('file_premium_up')) {
                $file = $request->file('file_premium_up');
                $songName = $song->song_name;
                $quality = 'lossless';
                $url_premium = Music::up_file_song($file, $songName, $quality);

                $path = Filepaths::where('song_id', '=', $id)->where('path_type', '=', 'premium')->first();
                if ($path != null) {
                    $path->update(['file_path' =>  $url_premium]);
                } else {
                    Filepaths::Create([
                        'file_path' => $url_premium,
                        'path_type' => 'premium',
                        'song_id' => $id
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Up load file bài hát thành công');
        } catch (\Exception $e) {
            // Kiểm tra và xóa file dựa trên đường dẫn nội bộ (path_image)

            if (isset($path_basic) && Storage::disk('s3')->exists($path_basic)) {
                Storage::disk('')->delete($path_basic);
            }
            if (isset($path_plus) && Storage::disk('s3')->exists($path_plus)) {
                Storage::disk('')->delete($path_plus);
            }
            if (isset($path_premium) && Storage::disk('s3')->exists($path_premium)) {
                Storage::disk('')->delete($path_premium);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.' . $e);
        }
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
                    $song->delete();
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
        $songs = Music::onlyTrashed()->paginate(10);
        // dd($songs);
        return view('admin.music.trash.list-trash-music', compact('songs'));
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

    // public function delete_all_music()
    // {
    //     try {
    //         Music::withTrashed();
    //         dd(Music::withTrashed());
    //         return redirect()->back()->with('success', 'Xóa tất cả bài hát khỏi thùng rác thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát khỏi thùng rác thất bại.');
    //     }
    // }


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
            if ($songs->isEmpty()) {
                return redirect()->route('list-trash-music')->with('error', 'Không tìm thấy bài hát nào phù hợp với từ khóa');
            } else {
                toastr()->success('Tìm bài hát thành công');
                return view('admin.music.trash.list-trash-music', compact('songs'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy bài hát nào phù hợp với từ khóa.');
        }
    }
}
