<?php

namespace App\Models\Api;

use App\Models\Singer;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Songs;

class Search extends Model
{
    public static function searchSong($key)
    {

        $song = Songs::with(['singer', 'country', 'category', 'copyright'])
            ->where('songs.song_name', 'LIKE', '%' . $key . '%')
            ->whereNull('songs.deleted_at')
            ->limit(10) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi

        $songsArray = $song->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'song_name' => $bh->song_name,
                'song_image' => $bh->song_image,
                'singer_name' => $bh->singer->singer_name ?? null, // Tên ca sỹ
            ];
        });
        return $songsArray;
    }

    public static function searchSinger($key)
    {
        $singer = Singer::where('singer_name', 'like', '%' . $key . '%')
            ->whereNull('deleted_at')
            ->limit(10) // Giới hạn 100 bản ghi
            ->get(); // Lấy tất cả các bản ghi
        $singersArray = $singer->map(function ($bh) {
            return (object) [
                'id' => $bh->id,
                'singer_name' => $bh->singer_name,
                'singer_image' => $bh->singer_image,
                'like_count' => $bh->like_count ?? null,
            ];
        });

        return $singersArray;
    }
}
