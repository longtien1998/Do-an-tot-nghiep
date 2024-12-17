<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Singer;
use Illuminate\Http\Request;

class SingerController extends Controller
{
    public function index()
    {
        $singers = Singer::all();
        return response()->json($singers, 200);
    }

    public function show($id)
    {
        $singer = Singer::find($id);
        if (!$singer) {
            return response()->json(['message' => 'Không tìm thấy ca sĩ'], 404);
        }
        return response()->json($singer, 200);
    }

    public function addFavourite(Request $request,)
    {
        $singer_id = $request->singer_id;
        $user_id = $request->user_id;
        $like = $request->liked;
        $singer = Singer::find($singer_id);
        if (!$singer) {
            return response()->json(['message' => 'Không tìm thấy ca sĩ'], 404);
        }
        $check = $singer->favouritesinger()
            ->wherePivot('user_id', $user_id)
            ->exists();
        // dd($check);

        if ($like) {
            if ($check) {
                // Add the singer to the user's favorite list
                return response()->json(['message' => 'Đã thêm Ca sĩ này vào yêu thích'], 200);
            } else {
                $singer->favouritesinger()->attach($user_id);
                return response()->json(['message' => 'Đã thêm Ca sĩ này vào yêu thích'], 200);
            }
        } else {
            if ($check) {
                // Add the singer to the user's favorite list
                $singer->favouritesinger()->detach($user_id);
                return response()->json(['message' => 'Đã xóa Ca sĩ này khỏi yêu thích'], 200);
            } else {
                return response()->json(['message' => 'Đã xóa Ca sĩ này khỏi yêu thích'], 200);
            }
        }

    }
    public function removeFavourite(Request $request)
    {
        $singer_id = $request->singer_id;
        $user_id = $request->user_id;
        $singer = Singer::find($singer_id);
        if (!$singer) {
            return response()->json(['message' => 'Không tìm thấy ca sĩ'], 404);
        }
        $check = $singer->favouritesinger()
            ->wherePivot('user_id', $user_id)
            ->exists();
        // dd($check);
        if ($check) {
            // Add the singer to the user's favorite list
            $singer->favouritesinger()->detach($user_id);
            return response()->json(['message' => 'Xóa ca sĩ yêu thích thành công'], 200);
        } else {
            return response()->json(['message' => 'Ca sĩ này không có trong yêu thích'], 400);
        }
    }
}
