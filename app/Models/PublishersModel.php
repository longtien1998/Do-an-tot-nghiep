<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PublishersModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'publishers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'publisher_name',
        'alias_name',
        'country',
        'city',
        'address',
        'website',
        'email',
        'phone',
        'logo',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        ];


    public static function up_image_Pulisher($file, $Pulisher){
        try {
            $PulisherSlug = Str::slug($Pulisher, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = time() . '_' . $PulisherSlug . '.' . strtolower($extension); // Đặt tên file

            // Đường dẫn lưu trữ trên S3
            $path = 'Pulisher_logo/';

            // Upload file lên S3 với tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_logo = Storage::disk('s3')->url($path . $fileName); // Chú ý: cần thêm $fileName vào đây

            return $url_logo;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }
}
