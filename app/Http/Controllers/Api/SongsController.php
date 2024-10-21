<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Songs;

class SongsController extends Controller
{
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
            return response()->json($songs, 200);
        }
    }

    public function songs_rand_10(){

        $songs = Songs::inRandomOrder()->take(10)->get(); // Lấy ngẫu nhiên 10 bài

        if($songs->isEmpty()){
            return response()->json([
                'message' =>'Không có bài hát',

            ],404);
        } else {
            return response()->json($songs, 200);
        }
    }
}
