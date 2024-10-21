<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Music extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'songs';
    protected $primaryKey  = 'id';
    protected $fillable = [
        'id',
        'song_name',
        'description',
        'lyrics',
        'singers_id',
        'categories_id',
        'song_image',
        'release_date',
        'listen_count',
        'provider',
        'composer',
        'download_count',
    ];

    public static function up_image_song($file, $songName)
    {
        try {
            $songNameSlug = Str::slug($songName, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = $songNameSlug .'.' . strtolower($extension); // Đặt tên file

            // Đường dẫn lưu trữ trên S3
            $path = 'song_image/';

            // Upload file lên S3 với tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_image = Storage::disk('s3')->url($path.$fileName); // Chú ý: cần thêm $fileName vào đây

            return $url_image;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }
    public static function up_file_song($file, $songName, $quality)
    {
        try {
            $songNameSlug = Str::slug($songName, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = $songNameSlug . '_' . $quality . '.' . strtolower($extension); // Đặt tên file

            // Đường dẫn lưu trữ trên S3
            $path = 'music/' . $songNameSlug;

            // Upload file lên S3 với tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_song = Storage::disk('s3')->url($path . '/' . $fileName); // Chú ý: cần thêm $fileName vào đây

            return $url_song;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }
    public static function selectAll()
    {
        $songsList = DB::table('songs')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->select('songs.*', 'categories.categorie_name as category_name')
            ->whereNull('songs.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            // ->get();
            ->paginate(10);

        // return DB::table('songs')
        //     ->join('categories', 'songs.categories_id', '=', 'categories.id')
        //     ->select('songs.*', 'categories.categorie_name as category_name')
        //     ->get();
        // return songs::with('category')->first();// Lấy tất cả bản ghi
        return $songsList;
    }

    public static function show($id)
    {

        $music = DB::table('songs')
            ->where('songs.id', $id)
            ->select('songs.*', 'categories.categorie_name as category_name')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->whereNull('songs.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            ->first(); // Lấy 1 bản ghi
        ;
        return $music;
    }

    public static function search_songs($search)
    {
        $songs = DB::table('songs')
            ->where('song_name', 'LIKE', '%' . $search . '%')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->select('songs.*', 'categories.categorie_name as category_name')
            ->whereNull('songs.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            // ->get();
            ->paginate(10);
        return $songs;
    }
}
