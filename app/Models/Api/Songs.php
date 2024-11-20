<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Singer;
use App\Models\Country;
use App\Models\Category;
use App\Models\Copyright;
use App\Models\Filepaths;
use App\Models\Ranking_log;
use Carbon\Carbon;

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

    public function singer()
    {
        return $this->belongsTo(Singer::class, 'singer_id', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function copyright()
    {
        return $this->belongsTo(Copyright::class, 'id', 'song_id');
    }


    public static function show($id)
    {
        // Bước 1: Lấy dữ liệu bài hát với các quan hệ liên quan
        $bh = self::with(['singer', 'country', 'category', 'copyright.publisher'])
            ->where('songs.id', '=', $id)
            ->whereNull('songs.deleted_at')
            ->first();

        if (!$bh) {
            return null; // Không tìm thấy bài hát
        }

        // Bước 2: Lấy danh sách file paths liên quan đến bài hát
        $filePaths = DB::table('file_paths')
            ->where('song_id', $id)
            ->select('path_type', 'file_path')
            ->get()
            ->pluck('file_path', 'path_type'); // Lấy mảng path_type => file_path

        // Bước 3: Tạo đối tượng kết quả
        $songsArray = (object) [
            'id' => $bh->id,
            'song_name' => $bh->song_name,
            'singer_name' => $bh->singer->singer_name ?? null,
            'singer_id' => $bh->singer_id,
            'country_name' => $bh->country->name_country ?? null,
            'country_id' => $bh->country_id,
            'category_name' => $bh->category->categorie_name ?? null,
            'category_id' => $bh->category_id,
            'provider' => $bh->provider,
            'composer' => $bh->composer,
            'download_count' => $bh->download_count,
            'copyright_type' => $bh->copyright->license_type ?? null,
            'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
            'description' => $bh->description,
            'lyrics' => $bh->lyrics,
            'song_image' => $bh->song_image,
            'release_day' => $bh->release_day,
            'listen_count' => $bh->listen_count,
            'file_paths' => $filePaths, // Đường dẫn tệp được gom nhóm
        ];

        return $songsArray;
    }

    // top 100 bảng xếp hạng tuần
    public static function bxh_tuan()
    {
        $weeklyRanking = DB::table('ranking_logs')
            ->select('song_id', DB::raw('SUM(listen_count) as count'), DB::raw('SUM(listen_count * 0.6 + download_count * 0.1 + like_count * 0.3) as weekly_score'))
            ->whereBetween('date', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])
            ->groupBy('song_id')
            ->orderByDesc('weekly_score')
            ->take(100) // Top 100 bài hát hàng tuần
            ->get()
            ->values();
        // dd($weeklyRanking);

        $ids = $weeklyRanking->pluck('song_id');
        // dd($ids);
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $bxh100 = self::with(['singer', 'country', 'category', 'copyright'])
            ->whereIn('id', $ids) // Chỉ lấy các bài hát có song_id trong danh sách xếp hạng hàng tuần
            ->whereNull('songs.deleted_at')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        $songsArray = $bxh100->map(function ($bh) {
            $listen = Ranking_log::where('song_id', $bh->id)
                ->select('song_id', DB::raw('SUM(listen_count) as count'))
                ->groupBy('song_id')
                ->whereBetween('date', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])

                ->first();
                $listen_count = $listen ? intval($listen->count) : 0;
                // dd($listen_count);

            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $listen_count,
            ];
        });

        // dd($songsArray);
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
            $song->file_paths = (object)$paths;

            return $song;
        });
        // dd($songsWithPaths);
        $sortedSongs = $ids->map(function ($id) use ($songsWithPaths) {
            return $songsWithPaths->firstWhere('id', $id);
        });
        // Trả về danh sách bài hát đã gắn file_paths
        return $sortedSongs;
    }

    // ngẫu nhiên 10 bài hát
    public static function getRandomSongs10()
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $randum = self::with(['singer', 'country', 'category', 'copyright'])
            ->whereNull('songs.deleted_at')
            ->orderBy('songs.listen_count', 'desc')
            ->inRandomOrder()
            ->limit(10) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi
        $songsArray = $randum->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
            ];
        });
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


    //bài hát theo quốc gia
    public static function list_song_Country($id)
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $song_Country = self::with(['singer', 'country', 'category', 'copyright'])
            ->where('country_id', '=', $id)
            ->whereNull('songs.deleted_at')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi
        $songsArray = $song_Country->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
            ];
        });
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

    //bài hát theo thể loại
    public static function list_song_category($id)
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $song_category = self::with(['singer', 'country', 'category', 'copyright'])
            ->where('category_id', '=', $id)
            ->whereNull('songs.deleted_at')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi
        $songsArray = $song_category->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
            ];
        });
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


    //bài hát theo ca sĩ
    public static function list_song_singer($id)
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $song_singer = self::with(['singer', 'country', 'category', 'copyright'])
            ->where('singer_id', '=', $id)
            ->whereNull('songs.deleted_at')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi
        $songsArray = $song_singer->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
            ];
        });
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

    // top thịnh hành
    public static function topTrennding()
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $song_singer = self::with(['singer', 'country', 'category', 'copyright'])

            ->whereNull('songs.deleted_at')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi
        $songsArray = $song_singer->map(function ($bh) {
            $totalScore = $bh->listen_count * 0.6 + $bh->download_count * 0.1 + $bh->like_count * 0.3;
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
                'total_score' => $totalScore,
            ];
        })->sortByDesc('total_score')->values();
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

    // top lượt nghe tổng
    public static function topListen()
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $bxh100 = self::with(['singer', 'country', 'category', 'copyright'])
            ->whereNull('songs.deleted_at')
            ->orderBy('songs.listen_count', 'desc')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        $songsArray = $bxh100->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
            ];
        });

        // dd($sortedSongs);
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
            $song->file_paths = (object)$paths;

            return $song;
        });
        // dd($songsWithPaths);

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }


    //top lượt like tổng
    public static function topLike()
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $bxh100 = self::with(['singer', 'country', 'category', 'copyright'])
            ->whereNull('songs.deleted_at')
            ->orderBy('songs.like_count', 'desc')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        $songsArray = $bxh100->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
            ];
        });

        // dd($sortedSongs);
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
            $song->file_paths = (object)$paths;

            return $song;
        });
        // dd($songsWithPaths);

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }

    // top lượt tải tổng
    public static function topDownload()
    {
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $bxh100 = self::with(['singer', 'country', 'category', 'copyright'])
            ->whereNull('songs.deleted_at')
            ->orderBy('songs.download_count', 'desc')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        $songsArray = $bxh100->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
                'singer_id' => $bh->singer_id,
                'country_name' => $bh->country->name_country ?? null, // Tên quốc gia
                'country_id' => $bh->country_id,
                'category_name' => $bh->category->categorie_name ?? null, // Tên thể loại
                'category_id' => $bh->category_id,
                'provider' => $bh->provider,
                'composer' => $bh->composer,
                'download_count' => $bh->download_count,
                'copyright_type' => $bh->copyright->license_type ?? null,
                'publisher_name' => $bh->copyright->publisher->publisher_name ?? null,
                'description' => $bh->description,
                'lyrics' => $bh->lyrics,
                'song_image' => $bh->song_image,
                'release_day' => $bh->release_date,
                'listen_count' => $bh->listen_count,
            ];
        });

        // dd($sortedSongs);
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
            $song->file_paths = (object)$paths;

            return $song;
        });
        // dd($songsWithPaths);

        // Trả về danh sách bài hát đã gắn file_paths
        return $songsWithPaths;
    }
}
