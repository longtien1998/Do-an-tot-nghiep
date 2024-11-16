<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'country';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name_country',
        'background',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function up_image($file, $name){
        try {
            $nameSlug = Str::slug($name, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = time() . '_' . $nameSlug . '.' . strtolower($extension); // Đặt tên file

            // Đường dẫn lưu trữ trên S3
            $path = 'country/';

            // Upload file lên S3 với tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_image = Storage::disk('s3')->url($path . $fileName); // Chú ý: cần thêm $fileName vào đây

            return $url_image;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }
}
