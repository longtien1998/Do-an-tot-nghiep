<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\FavouriteSong;
use Illuminate\Http\Request;
use App\Models\Music;
use Carbon\Carbon;
use App\Models\Ranking_log;


class FavouriteSongController extends Controller
{
    public function list_song_favourite($id)
    {
        $getAll = FavouriteSong::where('user_id', $id)->get()->pluck('id');
        return response()->json($getAll);
    }

    public function check_song_favourite(Request $request){
        $song_id = $request->song_id;
        $user_id = $request->user_id;
        $check = Music::find($song_id)->favouritesong()
            ->wherePivot('user_id', $user_id)
            ->exists();
        return response()->json($check);
    }

    public function add_song_favourite(Request $request)
    {
        $like = $request->liked;
        $user_id = $request->user_id;
        $song_id = $request->song_id;
        $song = Music::find($song_id);
        if (!$song) {
            return response()->json(['message' => 'Không tìm thấy ca sĩ'], 404);
        }
        $check = $song->favouritesong()
            ->wherePivot('user_id',  $request->user_id)
            ->exists();
        // dd($check);

        if ($like) {
            if ($check) {

                // Add the song to the user's favorite list
                return response()->json(['message' => 'Đã thêm bài hát này vào yêu thích'], 200);
            } else {
                $song->favouritesong()->attach($user_id);
                $song->like_count += 1;
                $song->save();
                $this->up_song_favourite($song_id,$user_id,);
                return response()->json(['message' => 'Đã thêm bài hát này vào yêu thích'], 200);
            }
        } else {
            if ($check) {
                // Add the song to the user's favorite list
                $song->favouritesong()->detach($user_id);
                $song->like_count -= 1;
                $song->save();
                $this->down_song_favourite($song_id,$user_id,);
                return response()->json(['message' => 'Đã xóa bài hát này khỏi yêu thích'], 200);
            } else {
                return response()->json(['message' => 'Đã xóa bài hát này khỏi yêu thích'], 200);
            }
        }
    }
    public function up_song_favourite($song_id, $user_id)
    {
        $ranKing = Ranking_log::where('song_id', '=', $song_id)->orWhere('date', '=', now())->first();
        if (!$ranKing) {
            $ranKing = new Ranking_log();
            $ranKing->song_id = $song_id;
            $ranKing->date = Carbon::today();
            $ranKing->like_count = 1;
            $ranKing->save();
        } else {
            $ranKing->like_count += 1;
            $ranKing->save();
        }
    }

    public function down_song_favourite($song_id, $user_id)
    {
        $ranKing = Ranking_log::where('song_id', '=', $song_id)->orWhere('date', '=', now())->first();
        if ($ranKing) {
            $ranKing->like_count -= 1;
            $ranKing->save();
        }
    }
}
