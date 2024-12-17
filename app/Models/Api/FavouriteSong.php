<?php

namespace App\Models\Api;

use App\Models\Music;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class FavouriteSong extends Model
{
    use HasFactory;
    protected $table = 'favorite_song';
    protected $fillable = [
        'user_id',
        'song_id',
    ];

    public static function favoritesong($id)
    {
        $weeklyRanking = self::where('user_id', '=', $id)
            ->get()
            ->values();
        // dd($weeklyRanking);

        $ids = $weeklyRanking->pluck('song_id');
        // dd($ids);
        // Bước 1: Lấy dữ liệu các bài hát với giới hạn 100 bản ghi
        $bxh100 = Songs::with(['singer', 'country', 'category', 'copyright'])
            ->whereIn('id', $ids) // Chỉ lấy các bài hát có song_id trong danh sách xếp hạng hàng tuần
            ->whereNull('songs.deleted_at')
            ->limit(100) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        $songsArray = $bxh100->map(function ($bh) {
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
                'listen_count' => $bh->listen_count,
                'time' => $bh->time,
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

}
