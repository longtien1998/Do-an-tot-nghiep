<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Filepaths;
use App\Models\Singer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        'singer_id',
        'category_id',
        'country_id',
        'song_image',
        'release_day',
        'time',
        'listen_count',
        'provider',
        'composer',
        'download_count',
        'updated_at',
        'created_at',
    ];

    public function category()
    {
        return $this->belongto(Category::class);
    }

    public static function url($perPage)
    {
        try {


            // Bước 1: Lấy dữ liệu các bài hát với phân trang
            $paginatedSongs = DB::table('songs')
                ->join('categories', 'songs.category_id', '=', 'categories.id')
                ->join('country', 'songs.country_id', '=', 'country.id')
                ->join('singers', 'songs.singer_id', '=', 'singers.id')
                ->whereNull('songs.deleted_at')
                ->select(
                    'songs.id',
                    'songs.song_name'
                )
                ->paginate($perPage); // Sử dụng $perPage để xác định số bản ghi trên mỗi trang

            // Bước 2: Lấy danh sách song_id
            $songIds = $paginatedSongs->pluck('id'); // Lấy danh sách song_id từ paginator

            // Bước 3: Lấy các file_paths liên quan đến bài hát
            $filePaths = DB::table('file_paths')
                ->whereIn('song_id', $songIds)
                ->select('song_id', 'path_type', 'file_path')
                ->get()
                ->groupBy('song_id'); // Gom nhóm theo song_id

            // Bước 4: Gắn file_paths vào từng bài hát
            $songsWithPaths = $paginatedSongs->getCollection()->map(function ($song) use ($filePaths) {
                $paths = $filePaths->get($song->id, collect())->reduce(function ($carry, $item) {
                    $carry[$item->path_type] = $item->file_path;
                    return $carry;
                }, []);

                // Đảm bảo file_paths là một object
                $song->file_paths = (object)$paths; // Gắn file_paths vào bài hát
                return $song;
            });

            // Bước 5: Tạo lại Paginator với dữ liệu đã xử lý
            $newPaginator = new LengthAwarePaginator(
                $songsWithPaths,
                $paginatedSongs->total(),
                $paginatedSongs->perPage(),
                $paginatedSongs->currentPage(),
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
            );

            // Trả về paginator đã cập nhật
            return $newPaginator;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }

    public static function up_image_song($file, $songName)
    {
        try {
            $songNameSlug = Str::slug($songName, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = time() . '_' . $songNameSlug . '.' . strtolower($extension); // Đặt tên file

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
            $fileName = time() . '_' . $songNameSlug . '_' . $quality . '.' . strtolower($extension); // Đặt tên file


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
            ->join('categories', 'songs.category_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singer_id', '=', 'singers.id')
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
            $query->where('songs.category_id', $filterTheloai);
        }

        // Áp dụng bộ lọc theo ca sĩ
        if ($filterSinger) {
            $query->where('songs.singer_id', $filterSinger); // Giả định rằng bạn có một trường `singer_id` trong bảng `songs`
        }

        // Áp dụng bộ lọc theo ngày phát hành
        if ($filterRelease) {
            $query->whereDate('songs.release_day', $filterRelease); // Giả định rằng bạn có trường `release_date`
        }

        // Áp dụng bộ lọc theo ngày tạo
        if ($filterCreate) {
            $query->whereDate('songs.created_at', $filterCreate); // Giả định rằng bạn có trường `created_at`
        }
        $query->orderBy('id', 'asc');
        $songsList = $query->paginate($perPage);
        // dd($songsList);
        return $songsList;
    }

    public static function show($id)
    {
        $song = Music::find($id);
        $file_paths_basic = Filepaths::where('song_id', '=', $song->id)->where('path_type', '=', 'basic')->first();
        $file_paths_plus = Filepaths::where('song_id', '=', $song->id)->where('path_type', '=', 'plus')->first();
        $file_paths_premium = Filepaths::where('song_id', '=', $song->id)->where('path_type', '=', 'premium')->first();

        return (object)[
            'id'                 => $song->id,
            'song_name'          => $song->song_name,
            'description'        => $song->description,
            'lyrics'             => $song->lyrics,
            'country_id'         => $song->country_id,
            'country_name'       => Country::find($song->country_id)->name_country,
            'category_id'        => $song->category_id,
            'category_name'      => Category::find($song->category_id)->categorie_name,
            'singer_id'          => $song->singer_id,
            'singer_name'        => Singer::find($song->singer_id)->singer_name,
            'song_image'         => $song->song_image,
            'release_day'        => $song->release_day,
            'time'               => $song->time,
            'listen_count'       => $song->listen_count,
            'provider'           => $song->provider,
            'composer'           => $song->composer,
            'download_count'     => $song->download_count,
            'created_at'         => $song->created_at,
            'updated_at'         => $song->updated_at,
            'file_path_basic'    => $file_paths_basic ? $file_paths_basic->file_path : null,
            'file_path_plus'     => $file_paths_plus ? $file_paths_plus->file_path : null,
            'file_path_premium'  => $file_paths_premium ? $file_paths_premium->file_path : null,
        ];
    }




    public static function search_songs($search)
    {
        $songs = DB::table('songs')
            ->join('categories', 'songs.category_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singer_id', '=', 'singers.id')
            ->where('songs.song_name', 'LIKE', '%' . $search . '%')
            ->select(
                'songs.*',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name'
            )
            ->whereNull('songs.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            // ->get();
            ->paginate(10);
        return $songs;
    }
}
