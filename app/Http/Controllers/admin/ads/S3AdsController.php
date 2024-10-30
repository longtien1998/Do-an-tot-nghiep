<?php

namespace App\Http\Controllers\admin\ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Advertisements;

class S3AdsController extends Controller
{
    public function file_ads()
    {
        try {
            // Lấy tất cả các file trong folder 'ads'
            $files = Storage::disk('s3')->allFiles('ads');
            // dd($files);

            // Lấy danh sách file nhạc từ bảng file_paths
            $usedFiles = Advertisements::pluck('file_path')->toArray();
            // dd( $files,$usedFiles);
            // Tạo danh sách file kèm thông tin sử dụng
            $advertisements = array_map(function ($file) use ($usedFiles) {
                return [
                    'path'    => $file,
                    'url'     => Storage::disk('s3')->url($file),
                    'in_use'  => in_array(Storage::disk('s3')->url($file), $usedFiles), // Kiểm tra file có đang dùng
                ];
            }, $files);

            return view('admin.advertisements.AllS3Ads', compact('advertisements'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách file: ' . $e->getMessage());
        }
    }

    // Xóa file nhạc trên S3
    public function destroy_file_ads(Request $request)
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
