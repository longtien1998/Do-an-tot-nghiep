<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Songs;
use App\Http\Resources\SongsResource;

class SongsController extends Controller
{
    public function show($id){
        $song = Songs::find($id);
        if($song){
            return response()->json($song);
        } else {
            return response()->json(['message' => 'Không tìm thấy bài hát'], 404);
        }

    }
    public function luot_nghe($id){
        $song = Songs::find($id);
        if($song){
            $song->listen_count += 1;
            $song->save();
            return response()->json([
                'message' => 'tăng lượt nghe thành công',

            ],200);
        } else {
            return response()->json(['message' => 'Không tìm thấy bài hát'], 404);
        }
    }
    public function luot_tai($id){
        $song = Songs::find($id);
        if($song){
            $song->download_count += 1;
            $song->save();
            return response()->json([
                'message' => 'tăng lượt tải thành công',

            ],200);
        } else {
            return response()->json(['message' => 'Không tìm thấy bài hát'], 404);
        }
    }
    public function bxh_100(){
        $songs = Songs::bxh_100();
        if($songs->isEmpty()){
            return response()->json([
                'message' =>'Không có bài hát',

            ],404);
        } else {
            return response()->json(SongsResource::collection($songs), 200);
        }
    }

    public function songs_rand_10(){

        $songs = Songs::getRandomSongs10(); // Lấy ngẫu nhiên 10 bài

        if($songs->isEmpty()){
            return response()->json([
                'message' =>'Không có bài hát',

            ],404);
        } else {
            return response()->json($songs, 200);
        }
    }


    // Bài hát theo thể loại quốc gia
    public function list_song_Country($id){
        $songs = Songs::list_song_Country($id);
        if($songs->isEmpty()){
            return response()->json([
                'message' =>'Không có bài hát trong thể loại này',

            ],404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Bài hát theo thể loại
    public function list_song_category($id){
        $songs = Songs::list_song_category($id);
        if($songs->isEmpty()){
            return response()->json([
                'message' =>'Không có bài hát trong thể loại này',

            ],404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Bài hát theo ca sĩ
    public function list_song_singer($id){
        $songs = Songs::list_song_singer($id);
        if($songs->isEmpty()){
            return response()->json([
                'message' =>'Không có bài hát của ca sĩ này',

            ],404);
        } else {
            return response()->json($songs, 200);
        }
    }
}
