<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Songs;
use App\Http\Resources\SongsResource;
use App\Models\Ranking_log;
use Carbon\Carbon;

class SongsController extends Controller
{
    public function show($id)
    {
        $song = Songs::show($id);
        if ($song) {
            return response()->json($song);
        } else {
            return response()->json(['message' => 'Không tìm thấy bài hát'], 404);
        }
    }
    public function luot_nghe($id)
    {
        $song = Songs::find($id);
        if ($song) {
            $song->listen_count += 1;
            $song->save();
            $ranKing = Ranking_log::where('song_id', '=', $id)->where('date', '=', Carbon::today())->first();
            if (!$ranKing) {
                $ranKing = new Ranking_log();
                $ranKing->song_id = $id;
                $ranKing->date =  Carbon::today();
                $ranKing->listen_count = 1;
                $ranKing->save();
            } else {
                $ranKing->listen_count += 1;
                $ranKing->save();
            }
            return response()->json([
                'message' => 'tăng lượt nghe thành công',
                'data' =>  Carbon::today()
            ], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy bài hát'], 404);
        }
    }
    public function luot_tai($id)
    {
        $song = Songs::find($id);
        if ($song) {
            $song->download_count += 1;
            $song->save();
            $ranKing = Ranking_log::where('song_id', '=', $id)->where('date', '=', Carbon::today())->first();
            if (!$ranKing) {
                $ranKing = new Ranking_log();
                $ranKing->song_id = $id;
                $ranKing->date =  Carbon::today();
                $ranKing->download_count = 1;
                $ranKing->save();
            } else {
                $ranKing->download_count += 1;
                $ranKing->save();
            }
            return response()->json([
                'message' => 'tăng lượt tải thành công',
                'date' =>  Carbon::today()

            ], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy bài hát'], 404);
        }
    }
    public function bxh_100()
    {
        $songs = Songs::bxh_tuan();
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát',

            ], 404);
        } else {
            return response()->json(SongsResource::collection($songs), 200);
        }
    }

    public function songs_rand_10()
    {

        $songs = Songs::getRandomSongs10(); // Lấy ngẫu nhiên 10 bài

        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }


    // Bài hát theo thể loại quốc gia
    public function list_song_Country($id)
    {
        $songs = Songs::list_song_Country($id);
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát trong thể loại này',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Bài hát theo thể loại
    public function list_song_category($id)
    {
        $songs = Songs::list_song_category($id);
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát trong thể loại này',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Bài hát theo ca sĩ
    public function list_song_singer($id)
    {
        $songs = Songs::list_song_singer($id);
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát của ca sĩ này',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Bài hát theo toptrending
    public function list_song_trending()
    {
        $songs = Songs::topTrennding();
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát của ca sĩ này',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Top lượt nghe
    public function top_listen()
    {
        $songs = Songs::topListen();
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Top lượt like
    public function top_like()
    {
        $songs = Songs::topLike();
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }


    // Top lượt tải
    public function top_download()
    {
        $songs = Songs::topDownload();
        if ($songs->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài hát',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }

    // Bài hát mới nhất
    public function new_song(){
        $songs = Songs::new_Song();
        if ($songs->isEmpty()) {
            return response()->json([
               'message' => 'Không có bài hát',

            ], 404);
        } else {
            return response()->json($songs, 200);
        }
    }
}
