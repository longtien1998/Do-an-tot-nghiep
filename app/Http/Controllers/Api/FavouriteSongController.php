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

    public function add_song_favourite(Request $request)
    {
        $data = $request->all();
        if (FavouriteSong::where('user_id', $data['user_id'])->where('song_id', $data['song_id'])->first()) {

            return response()->json(['message' => 'Bài hát đã có trong danh sách yêu thích']);
        }
        $add = FavouriteSong::create($data);

        $song = Music::find($data['song_id']);
        $song->like_count += 1;
        $song->save();
        $ranKing = Ranking_log::where('song_id', '=',$data['song_id'])->orWhere('date', '=', now())->first();
        if(!$ranKing) {
            $ranKing = new Ranking_log();
            $ranKing->song_id = $data['song_id'];
            $ranKing->date = Carbon::today();
            $ranKing->like_count = 1;
            $ranKing->save();
        } else{
            $ranKing->like_count += 1;
            $ranKing->save();
        }
        // dd($data);
        return response()->json($add);
    }

    public function delete_song_favourite(Request $request)
    {
        $data = $request->all();
        $delete = FavouriteSong::where('user_id', $data['user_id'])->where('song_id', $data['song_id'])->delete();
        if ($delete) {
            $song = Music::find($data['song_id']);
            $song->like_count -= 1;
            $song->save();
            return response()->json(['message' => 'Xóa bài hát khỏi danh sách yêu thích thành công']);
        } else {
            return response()->json(['message' => 'Xóa bài hát khỏi danh sách yêu thích thất bại']);
        }
    }
}
