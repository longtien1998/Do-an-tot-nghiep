<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class Singer extends Model
{
    use HasFactory,SoftDeletes;
    // Upload ảnh ca sĩ lên S3
    public static function up_image_singer($file, $singerName)
    {
        try {
            $singerNameSlug = Str::slug($singerName, '_');
            $extension = $file->getClientOriginalExtension();
            $fileName = $singerNameSlug . '.' . strtolower($extension);
            $path = 'singer_image/';

            // Upload file lên S3 và đặt tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_image = Storage::disk('s3')->url($path . $fileName);

            return $url_image;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    // Lấy tất cả ca sĩ với phân trang
    public static function selectAll()
    {
        return DB::table('singers')
            ->select('singers.*')
            ->whereNull('singers.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            ->paginate(10);
    }

    // Hiển thị thông tin chi tiết của một ca sĩ
    public static function show($id)
    {
        return DB::table('singers')
            ->where('singers.id', $id)
            ->select('singers.*')
            ->whereNull('singers.deleted_at') // Chỉ lấy bản ghi chưa bị soft delete
            ->first(); // Lấy một bản ghi
    }

    // Tìm kiếm ca sĩ theo tên
    public static function search_singers($search)
    {
        return DB::table('singers')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->select('singers.*')
            ->whereNull('singers.deleted_at') // Chỉ lấy bản ghi chưa bị soft delete
            ->paginate(10);
    }

}
