<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Playlist extends Model
{
    protected $table = 'playlists';
    protected $fillable = [
        'playlist_name',
        'share',
        'user_id',
        'created_at',
        'updated_at',
    ];
    public function playlist_song():BelongsToMany {
        return $this->belongsToMany(Songs::class, 'playlist_song', 'playlist_id','song_id');
    }

    public static function getsong($songsid){
        $songs = Songs::whereIn('id', $songsid)->get();
        $songsArray = $songs->map(function ($bh) {
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

        return $songsWithPaths;
    }
}
