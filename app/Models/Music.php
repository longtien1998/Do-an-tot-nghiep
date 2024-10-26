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
        'release_day',
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
            $fileName =time().'_'. $songNameSlug . '.' . strtolower($extension); // Đặt tên file

            // Đường dẫn lưu trữ trên S3
            $path = 'song_image/';

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
    public static function up_file_song($file, $songName, $quality)
    {
        try {
            $songNameSlug = Str::slug($songName, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName =time().'_'. $songNameSlug . '_' . $quality . '.' . strtolower($extension); // Đặt tên file

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
    public static function selectAll($perPage, $filterTheloai, $filterSinger, $filterRelease, $filterCreate)
    {
        $query = DB::table('songs')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singers_id', '=', 'singers.id')
            ->select(
                'songs.*',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name'
            )
            ->whereNull('songs.deleted_at'); // Chỉ lấy những bản ghi chưa bị soft delete
            // ->get();


        // Áp dụng bộ lọc theo thể loại
        if ($filterTheloai) {
            $query->where('songs.categories_id', $filterTheloai);
        }

        // Áp dụng bộ lọc theo ca sĩ
        if ($filterSinger) {
            $query->where('songs.singers_id', $filterSinger); // Giả định rằng bạn có một trường `singer_id` trong bảng `songs`
        }

        // Áp dụng bộ lọc theo ngày phát hành
        if ($filterRelease) {
            $query->whereDate('songs.release_day', $filterRelease); // Giả định rằng bạn có trường `release_date`
        }

        // Áp dụng bộ lọc theo ngày tạo
        if ($filterCreate) {
            $query->whereDate('songs.created_at', $filterCreate); // Giả định rằng bạn có trường `created_at`
        }

        $songsList = $query->paginate($perPage);
        return $songsList;
    }

    public static function show($id)
    {
        // Lấy thông tin bài hát cùng các file_paths
        $music = DB::table('songs')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singers_id', '=', 'singers.id')
            ->leftJoin('file_paths', 'songs.id', '=', 'file_paths.song_id')
            ->where('songs.id', $id)
            ->whereNull('songs.deleted_at')
            ->select(
                'songs.*',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name',
                'file_paths.file_path',
                'file_paths.path_type',  // Lấy path_type
            )
            ->get(); // Lấy tất cả các file_path cho bài hát

        // Xử lý: Chuyển thành object chứa các file_paths
        $musicData = $music->groupBy('id')->map(function ($items) {
            $first = $items->first(); // Lấy thông tin bài hát từ bản ghi đầu tiên

            // Chuyển tất cả file_paths thành một mảng object
            $filePaths = $items->reduce(function ($carry, $item) {
                $carry[$item->path_type] = $item->file_path;
                return $carry;
            }, []);

            // Trả về object bài hát với thông tin đầy đủ
            return (object)[
                'id'            => $first->id,
                'song_name'         => $first->song_name,
                'description'    => $first->description,
                'lyrics'         => $first->lyrics,
                'song_image' => $first->song_image,
                'release_day' => $first->release_day,
                'listen_count' => $first->listen_count,
                'provider' => $first->provider,
                'composer' => $first->composer,
                'download_count' => $first->download_count,
                'category_name' => $first->category_name,
                'country_name'  => $first->country_name,
                'singer_name'   => $first->singer_name,
                'file_paths'    => (object)$filePaths,

                // Mảng các object file_path
            ];
        })->first(); // Lấy bài hát duy nhất (vì chỉ tìm theo ID)

        return $musicData;
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
