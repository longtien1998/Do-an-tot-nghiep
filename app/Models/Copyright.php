<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;



class Copyright extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'copyrights';

    protected $fillable = [
        'id',
        'song_id',
        'publisher_id',
        'license_type',
        'issue_day',
        'expiry_day',
        'usage_rights',
        'terms',
        'terms',
        'price',
        'payment',
        'location',
        'pay_day',
        'license_file',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'issue_day' => 'datetime',
        'expiry_day' => 'datetime',
        'pay_day' => 'datetime',
        'price' => 'float'
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function song()
    {
        return $this->belongsTo(Music::class);
    }

    public static function file_copyright($file, $type)
    {
        try {
            if ($type) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '-giay-phep.' . $extension;
                $path = 'copyright/';

                // Upload file lên S3 với tên tùy chỉnh
                Storage::disk('s3')->putFileAs($path, $file, $filename);
                Storage::disk('s3')->setVisibility($path . $filename, 'public');

                // Lấy URL công khai của file đã upload
                $url = Storage::disk('s3')->url($path . $filename); // Chú ý: cần thêm $fileName vào đây
            } else {
                // Tạo PDF từ nội dung HTML
                $pdf = PDF::loadHTML($file);
                $fileName = 'copyright/' . time() . '-giay-phep.pdf';
                $fileContent = $pdf->output(); // Lấy nội dung PDF dưới dạng raw content

                // Lưu lên S3
                Storage::disk('s3')->put($fileName, $fileContent);

                // Trả về URL của file đã lưu
                $url = Storage::disk('s3')->url($fileName);
            }

            return $url;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }

    public static function checkfile(){
        // Lấy tất cả các file trong folder 'Pulisher_logo'
        $files = Storage::disk('s3')->allFiles('copyright');
        // Lấy danh sách ảnh từ bảng songs (music)
        $usedImages = self::pluck('license_file')->toArray();
        // Tạo danh sách ảnh kèm thông tin sử dụng
        $filescopyright = array_map(function ($file) use ($usedImages) {
            return [
                'path'    => $file,
                'url'     => Storage::disk('s3')->url($file),
                'in_use'  => in_array(Storage::disk('s3')->url($file), $usedImages), // Kiểm tra ảnh có đang dùng
            ];
        }, $files);
        return $filescopyright;
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

    public static function getAllTrash($perPage){
        return self::onlyTrashed()->paginate($perPage);
    }

    public static function search($search){


            $copyrights = Copyright::whereHas('song', function ($query) use ($search) {
                $query->where('song_name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('publisher', function ($query) use ($search) {
                $query->where('publisher_name', 'like', '%' . $search . '%');
            })
            ->paginate(20);

            return $copyrights;


    }

    public static function searchTrash($search){


        $copyrights = Copyright::whereHas('song', function ($query) use ($search) {
            $query->where('song_name', 'like', '%' . $search . '%');
        })
        ->orWhereHas('publisher', function ($query) use ($search) {
            $query->where('publisher_name', 'like', '%' . $search . '%');
        })
        ->onlyTrashed()
        ->paginate(20);

        return $copyrights;


}
}
