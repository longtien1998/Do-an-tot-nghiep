<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Album;
use App\Models\Api\FavoriteAlbum;
use Illuminate\Http\Request;

class FavouriteAlbumController extends Controller
{
    public function getAll($user_id){
        $album = FavoriteAlbum::where('user_id', '=', $user_id)->get();
        $albumid = $album->pluck('album_id');
        $albums = Album::whereIn('id', $albumid)->get();
        $data = $albums->map(function($album){
            return [
                'id' => $album->id,
                'image' => $album->image,
                'album_name' => $album->album_name,
                'listen_count' => $album->listen_count,
                'singer_name' => $album->singer->singer_name,
                'singer_id' => $album->singer_id,
                'creation_date' => $album->creation_date,
            ];
        });
        return response()->json($data);
    }

    public function addFavourite(Request $request)
    {
        $like = $request->liked;
        $user_id = $request->user_id;
        $album_id = $request->album_id;
        $album = Album::find($album_id);
        if (!$album) {
            return response()->json(['message' => 'Không tìm thấy Album'], 404);
        }
        $check = $album->favourite()
            ->wherePivot('user_id',  $request->user_id)
            ->exists();
        // dd($check);

        if ($like) {
            if ($check) {

                // Add the song to the user's favorite list
                return response()->json(['message' => 'Đã thêm Album này vào yêu thích'], 200);
            } else {
                $album->favourite()->attach($user_id);
                $album->save();
                return response()->json(['message' => 'Đã thêm Album này vào yêu thích'], 200);
            }
        } else {
            if ($check) {
                // Add the song to the user's favorite list
                $album->favourite()->detach($user_id);
                $album->save();
                return response()->json(['message' => 'Đã xóa Album này khỏi yêu thích'], 200);
            } else {
                return response()->json(['message' => 'Đã xóa Album này khỏi yêu thích'], 200);
            }
        }
    }
}
