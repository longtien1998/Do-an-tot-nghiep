<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Songs extends Model
{
    use HasFactory;
    protected $table = 'songs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'song_name',
        'description',
        'lyrics',
        'singer_id',
        'category_id',
        'country_id',
        'song_image',
        'release_date',
        'listen_count',
        'provider',
        'composer',
        'download_count',
    ];

    public static function bxh_100()
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $songsArray = DB::table('songs')
            ->join('categories', 'songs.category_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singer_id', '=', 'singers.id')
            ->whereNull('songs.deleted_at')
            ->orderBy('songs.listen_count', 'desc')
            ->select(
                'songs.id',
                'songs.song_name',
                'songs.description',
                'songs.lyrics',
                'songs.song_image',
                'songs.category_id',
                'songs.country_id',
                'songs.singer_id',
                'songs.release_day',
                'songs.listen_count',
                'songs.provider',
                'songs.composer',
                'songs.download_count',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name'
            )
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        // Bước 2: Lấy danh sách song_id
        $songIds = collect($songsArray)->pluck('id');

        // Bước 3: Lấy các file_paths liên quan đến bài hát
        $filePaths = DB::table('file_paths')
            ->whereIn('song_id', $songIds)
            ->select('song_id', 'path_type', 'file_path')
            ->get()
            ->groupBy('song_id'); // Gom nhóm theo song_id

        // Bước 4: Gắn file_paths vào từng bài hát
        $songsWithPaths = collect($songsArray)->map(function ($song) use ($filePaths) {
            $paths = $filePaths->get($song->id, collect())->reduce(function ($carry, $item) {
                $carry[$item->path_type] = $item->file_path;
                return $carry;
            }, []);

            // Đảm bảo file_paths là một object
            $song->file_paths = (object)$paths; // Gắn file_paths vào bài hát
            return $song;
        });

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }

    public static function getRandomSongs10()
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $songsArray = DB::table('songs')
            ->join('categories', 'songs.category_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singer_id', '=', 'singers.id')
            ->whereNull('songs.deleted_at')
            ->orderBy('songs.listen_count', 'desc')
            ->select(
                'songs.id',
                'songs.song_name',
                'songs.description',
                'songs.lyrics',
                'songs.song_image',
                'songs.release_day',
                'songs.listen_count',
                'songs.category_id',
                'songs.country_id',
                'songs.singer_id',
                'songs.provider',
                'songs.composer',
                'songs.download_count',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name'
            )
            ->inRandomOrder()
            ->limit(10) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        // Bước 2: Lấy danh sách song_id
        $songIds = collect($songsArray)->pluck('id');

        // Bước 3: Lấy các file_paths liên quan đến bài hát
        $filePaths = DB::table('file_paths')
            ->whereIn('song_id', $songIds)
            ->select('song_id', 'path_type', 'file_path')
            ->get()
            ->groupBy('song_id'); // Gom nhóm theo song_id

        // Bước 4: Gắn file_paths vào từng bài hát
        $songsWithPaths = collect($songsArray)->map(function ($song) use ($filePaths) {
            $paths = $filePaths->get($song->id, collect())->reduce(function ($carry, $item) {
                $carry[$item->path_type] = $item->file_path;
                return $carry;
            }, []);

            // Đảm bảo file_paths là một object
            $song->file_paths = (object)$paths; // Gắn file_paths vào bài hát
            return $song;
        });

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }


    public static function list_song_Country($id)
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $songsArray = DB::table('songs')
            ->where('country_id', '=', $id)
            ->join('categories', 'songs.category_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singer_id', '=', 'singers.id')
            ->whereNull('songs.deleted_at')
            ->select(
                'songs.id',
                'songs.song_name',
                'songs.description',
                'songs.lyrics',
                'songs.song_image',
                'songs.category_id',
                'songs.country_id',
                'songs.singer_id',
                'songs.release_day',
                'songs.listen_count',
                'songs.provider',
                'songs.composer',
                'songs.download_count',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name'
            )
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        // Bước 2: Lấy danh sách song_id
        $songIds = collect($songsArray)->pluck('id');

        // Bước 3: Lấy các file_paths liên quan đến bài hát
        $filePaths = DB::table('file_paths')
            ->whereIn('song_id', $songIds)
            ->select('song_id', 'path_type', 'file_path')
            ->get()
            ->groupBy('song_id'); // Gom nhóm theo song_id

        // Bước 4: Gắn file_paths vào từng bài hát
        $songsWithPaths = collect($songsArray)->map(function ($song) use ($filePaths) {
            $paths = $filePaths->get($song->id, collect())->reduce(function ($carry, $item) {
                $carry[$item->path_type] = $item->file_path;
                return $carry;
            }, []);

            // Đảm bảo file_paths là một object
            $song->file_paths = (object)$paths; // Gắn file_paths vào bài hát
            return $song;
        });

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }


    public static function list_song_category($id)
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $songsArray = DB::table('songs')
            ->where('category_id', '=', $id)
            ->join('categories', 'songs.category_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singer_id', '=', 'singers.id')
            ->whereNull('songs.deleted_at')
            ->select(
                'songs.id',
                'songs.song_name',
                'songs.description',
                'songs.lyrics',
                'songs.song_image',
                'songs.release_day',
                'songs.listen_count',
                'songs.category_id',
                'songs.country_id',
                'songs.singer_id',
                'songs.provider',
                'songs.composer',
                'songs.download_count',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name'
            )
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        // Bước 2: Lấy danh sách song_id
        $songIds = collect($songsArray)->pluck('id');

        // Bước 3: Lấy các file_paths liên quan đến bài hát
        $filePaths = DB::table('file_paths')
            ->whereIn('song_id', $songIds)
            ->select('song_id', 'path_type', 'file_path')
            ->get()
            ->groupBy('song_id'); // Gom nhóm theo song_id

        // Bước 4: Gắn file_paths vào từng bài hát
        $songsWithPaths = collect($songsArray)->map(function ($song) use ($filePaths) {
            $paths = $filePaths->get($song->id, collect())->reduce(function ($carry, $item) {
                $carry[$item->path_type] = $item->file_path;
                return $carry;
            }, []);

            // Đảm bảo file_paths là một object
            $song->file_paths = (object)$paths; // Gắn file_paths vào bài hát
            return $song;
        });

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }


    public static function list_song_singer($id)
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $songsArray = DB::table('songs')
            ->where('singer_id', '=', $id)
            ->join('categories', 'songs.category_id', '=', 'categories.id')
            ->join('country', 'songs.country_id', '=', 'country.id')
            ->join('singers', 'songs.singer_id', '=', 'singers.id')
            ->whereNull('songs.deleted_at')
            ->select(
                'songs.id',
                'songs.song_name',
                'songs.description',
                'songs.lyrics',
                'songs.song_image',
                'songs.release_day',
                'songs.listen_count',
                'songs.category_id',
                'songs.country_id',
                'songs.singer_id',
                'songs.provider',
                'songs.composer',
                'songs.download_count',
                'categories.categorie_name as category_name',
                'country.name_country as country_name',
                'singers.singer_name as singer_name'
            )
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        // Bước 2: Lấy danh sách song_id
        $songIds = collect($songsArray)->pluck('id');

        // Bước 3: Lấy các file_paths liên quan đến bài hát
        $filePaths = DB::table('file_paths')
            ->whereIn('song_id', $songIds)
            ->select('song_id', 'path_type', 'file_path')
            ->get()
            ->groupBy('song_id'); // Gom nhóm theo song_id

        // Bước 4: Gắn file_paths vào từng bài hát
        $songsWithPaths = collect($songsArray)->map(function ($song) use ($filePaths) {
            $paths = $filePaths->get($song->id, collect())->reduce(function ($carry, $item) {
                $carry[$item->path_type] = $item->file_path;
                return $carry;
            }, []);

            // Đảm bảo file_paths là một object
            $song->file_paths = (object)$paths; // Gắn file_paths vào bài hát
            return $song;
        });

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }
}
