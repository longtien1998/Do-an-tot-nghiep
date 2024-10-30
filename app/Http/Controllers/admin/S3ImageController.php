<?php

namespace App\Http\Controllers\admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Music;

class S3ImageController extends Controller
{
    // Hiển thị danh sách tất cả ảnh và kiểm tra ảnh nào đang được sử dụng
    public function image_songs()
    {
        try {
            // Lấy tất cả các file trong folder 'song_image'
            $files = Storage::disk('s3')->files('song_image');
            // Lấy danh sách ảnh từ bảng songs (music)
            $usedImages = Music::pluck('song_image')->toArray();
            // Tạo danh sách ảnh kèm thông tin sử dụng
            $images = array_map(function ($file) use ($usedImages) {
                return [
                    'path'    => $file,
                    'url'     => Storage::disk('s3')->url($file),
                    'in_use'  => in_array(Storage::disk('s3')->url($file), $usedImages), // Kiểm tra ảnh có đang dùng
                ];
            }, $files);

            return view('admin.music.file.All-image', compact('images'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách file: ' . $e->getMessage());
        }
    }

    // Xóa file ảnh trên S3
    public function destroy_image_songs(Request $request)
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

    public function list_destroy_image_songs(request $request){

        $list_destroy_songs = json_decode($request->delete_list, true);
        dd($list_destroy_songs);
        try{
            foreach ($list_destroy_songs as $file_path) {
                Storage::disk('s3')->delete($file_path);
            }
            return response()->json(['message' => 'Xóa file thành công']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi xóa file: '. $e->getMessage()]);
        }
    }
}


