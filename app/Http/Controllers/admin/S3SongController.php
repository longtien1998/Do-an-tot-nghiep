<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Filepaths;

class S3SongController extends Controller
{
    // Hiển thị danh sách tất cả file nhạc và kiểm tra file nào đang được sử dụng
    public function file_songs()
    {
        try {
            // Lấy tất cả các file trong folder 'songs'
            $files = Storage::disk('s3')->allFiles('music');
            // dd($files);

            // Lấy danh sách file nhạc từ bảng file_paths
            $usedFiles = Filepaths::pluck('file_path')->toArray();
            // dd( $files,$usedFiles);
            // Tạo danh sách file kèm thông tin sử dụng
            $songs = array_map(function ($file) use ($usedFiles) {
                return [
                    'path'    => $file,
                    'url'     => Storage::disk('s3')->url($file),
                    'in_use'  => in_array(Storage::disk('s3')->url($file), $usedFiles), // Kiểm tra file có đang dùng
                ];
            }, $files);

            return view('admin.music.AllS3Songs', compact('songs'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách file: ' . $e->getMessage());
        }
    }

    // Xóa file nhạc trên S3
    public function destroy_file_songs(Request $request)
    {
        try {
            if (Storage::disk('s3')->exists($request->path)) {
                Storage::disk('s3')->delete($request->path);
                return back()->with('success', 'Xóa file thành công.');
            } else {
                return back()->with('error', 'File không tồn tại.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi xóa file: ' . $e->getMessage());
        }
    }
}
