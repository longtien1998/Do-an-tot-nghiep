<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumSongs;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index(){
        $albums = Album::has('albumsong')->inRandomOrder()->get();
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
        return response()->json($data, 200);
    }
    public function album_singer($id){
        $albums = Album::where('singer_id','=', $id)->orderByDesc('created_at')->get();
        return response()->json($albums, 200);
    }

    public function show($id){
        $album = Album::find($id);
        $data = [
            'id' => $album->id,
            'image' => $album->image,
            'album_name' => $album->album_name,
            'listen_count' => $album->listen_count,
            'singer_name' => $album->singer->singer_name,
            'singer_id' => $album->singer_id,
            'creation_date' => $album->creation_date,
        ];
        return response()->json($data, 200);
    }
    public function list_song_album($id){
        $albumsongs = AlbumSongs::selectSong($id);
        return response()->json($albumsongs, 200);
    }
}
