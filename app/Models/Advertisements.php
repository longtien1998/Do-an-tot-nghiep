<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Advertisements extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ads';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'id',
        'ads_name',
        'ads_description',
        'file_path',
    ];

    public static function up_file_ads($file, $adsName)
    {
        try {
            $adsNameSlug = Str::slug($adsName, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = time().'_'. $adsNameSlug . '.' . strtolower($extension); // Đặt tên file


            // Đường dẫn lưu trữ trên S3
            $path = 'ads/' . $adsNameSlug;

            // Upload file lên S3 với tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_ads = Storage::disk('s3')->url($path . '/' . $fileName); // Chú ý: cần thêm $fileName vào đây

            return $url_ads;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }
    public static function createAds($data)
    {
        return DB::table('ads')->insert([
            'ads_name' => $data['ads_name'],
            'ads_description' => $data['ads_description'],
            'file_path' => $data['file_path'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public static function selectAds(){
        return DB::table('ads')
        ->select('id','ads_name','ads_description','file_path')
        ->whereNull('deleted_at')
        ->paginate(10);
    }
    public static function updateAds($id, $data)
    {
        return DB::table('ads')->where('id', $id)->update([
            'ads_name' => $data['ads_name'],
            'ads_description' => $data['ads_description'],
            'file_path' => $data['file_path'],
            'updated_at' => now(),
        ]);
    }
    public static function search_ads($search)
    {
        $ads = DB::table('ads')
            ->where('ads_name', 'LIKE', '%' . $search . '%')
            ->orWhere('ads_description', 'LIKE', '%' . $search . '%')
            ->select('ads.*')
            ->paginate(10);
        return $ads;
    }
}
