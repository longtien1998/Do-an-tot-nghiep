<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Publisher extends Model
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


    public static function up_image_Pulisher($file, $Pulisher)
    {
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

    public static function getImage(){
        // Lấy tất cả các file trong folder 'Pulisher_logo'
        $files = Storage::disk('s3')->files('Pulisher_logo');
        // Lấy danh sách ảnh từ bảng songs (music)
        $usedImages = self::pluck('logo')->toArray();
        // Tạo danh sách ảnh kèm thông tin sử dụng
        $images = array_map(function ($file) use ($usedImages) {
            return [
                'path'    => $file,
                'url'     => Storage::disk('s3')->url($file),
                'in_use'  => in_array(Storage::disk('s3')->url($file), $usedImages), // Kiểm tra ảnh có đang dùng
            ];
        }, $files);
        return $images;
    }

    public static function search($query)
    {
        return self::where('publisher_name', 'LIKE', '%' . $query . '%')
            ->orWhere('alias_name', 'LIKE', '%' . $query . '%')
            ->orWhere('country', 'LIKE', '%' . $query . '%')
            ->orWhere('city', 'LIKE', '%' . $query . '%')
            ->orWhere('address', 'LIKE', '%' . $query . '%')
            ->orWhere('website', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->orWhere('phone', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%')
            ->paginate(20);
    }

    public static function getAll($perPage, $filterCreateStart, $filterCreateEnd)
    {
        $query = self::whereNull('deleted_at');
        if ($filterCreateStart) {
            $query->where('created_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('created_at', '<=', $filterCreateEnd);
        }
        return $query->paginate($perPage);
    }

    public static function getAlltrash($perPage, $filterCreateStart, $filterCreateEnd)
    {
        $query = self::onlyTrashed();
        if ($filterCreateStart) {
            $query->where('deleted_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('deleted_at', '<=', $filterCreateEnd);
        }
        return $query->paginate($perPage);
    }

    public static function search_trash_publishers($searchQuery)
    {
        return self::onlyTrashed()
            ->where(function ($query) use ($searchQuery) {
                $query->where('publisher_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('alias_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('country', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('city', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('address', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('website', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchQuery . '%');
            })
            ->paginate(20);
    }
}
