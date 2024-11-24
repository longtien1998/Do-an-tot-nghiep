<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){

        $key = $request->input('search');
        $searchSongs = Search::searchSong($key);
        $searchSinger = Search::searchSinger($key);


        if ($searchSongs->isEmpty() && $searchSinger->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy kết quả',
            ], 404);
        } else {
            return response()->json([
                'songs' => $searchSongs,
                'singers' => $searchSinger,
            ], 200);
        }
    }
}
