<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Playlist;
use App\Models\Api\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    public function index($user_id)
    {
        $playlists = Playlist::where('user_id', $user_id)->get();
        if ($playlists->count() > 0) {
            return response()->json($playlists);
        } else {
            return response()->json(['message' => 'Tài khoản không có playlist nào'], 404);
        }
    }

    public function public_playlist(){
        $playlists = Playlist::where('share', true)->get();
        if ($playlists->count() > 0) {
            return response()->json($playlists);
        } else {
            return response()->json(['message' => 'Không có playlist công khai nào'], 404);
        }
    }

    public function public_playlist_detail($playlist_id){
        $playlist = Playlist::find($playlist_id);
        if ($playlist) {
            return response()->json($playlist);
        } else {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }
    }

    public function public_playlist_song($playlist_id){
        $playlist = Playlist::find($playlist_id);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }
        $songs = $playlist->playlist_song;
        if ($songs->isEmpty()) {
            return response()->json(['message' => 'Playlist không có bài hát nào.']);
        }
        $data = Playlist::getsong($songs->pluck('song_id'));
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'playlist_name' => 'required|string|max:255',
            'share' => 'nullable|boolean',
            'user_id' => 'required|integer'
        ], [
            'playlist_name.required' => 'Tên playlist không được để trống',
            'playlist_name.string' => 'Tên playlist phải là chuỗi',
            'playlist_name.max' => 'Tên playlist phải nhỏ hơn 255 ký tự',
            'share.boolean' => 'Share phải là một giá trị boolean',
            'user_id.required' => 'User ID không được để trống',
            'user_id.integer' => 'User ID phải là một số nguyên'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        $check = Playlist::where('playlist_name', '=', $request->playlist_name)->where('user_id', '=', $request->user_id)->count();
        if ($check > 0) {
            return response()->json(['message' => 'Playlist đã tồn tại'], 409);
        }

        $playlist = Playlist::create([
            'playlist_name' => $request->playlist_name,
            'share' => $request->share ?? false,
            'user_id' => $request->user_id,
            'background' => 'https://soundwave2.s3.us-east-2.amazonaws.com/playlist/album_default.png',
        ]);
        if ($playlist) {
            return response()->json($playlist, 201);
        }
        return response()->json(['message' => 'Tạo playlist thất bại'], 500);
    }

    public function list_song($playlist_id)
    {

        $playlist = Playlist::find($playlist_id);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }

        $songs = $playlist->playlist_song;


        if ($songs->isEmpty()) {
            return response()->json(['message' => 'Playlist không có bài hát nào.']);
        }
        $data = Playlist::getsong($songs->pluck('song_id'));
        return response()->json($data);
    }

    public function destroy($id)
    {
        $playlist = Playlist::find($id);
        if ($playlist) {
            $playlist->delete();
            return response()->json(['message' => 'Xóa playlist thành công'], 200);
        } else {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }
    }


    public function addSong(Request $request, $id)
    {
        $playlist = Playlist::find($id);

        if ($playlist) {
            $exists = $playlist->playlist_song()
                ->wherePivot('song_id', $request->song_id)
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Bài hát đã tồn tại trong playlist'], 409);
            }
            $count =  $playlist->playlist_song()->count();
            if ($count == 0) {
                $background = Songs::find($request->song_id)->song_image;
                $playlist->background = $background;
                $playlist->save();
            }
            $playlist->playlist_song()->attach($request->song_id);
            return response()->json(['message' => 'Thêm bài hát vào playlist thành công'], 200);
        } else {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }
    }

    public function removeSong($playlist_id, $song_id)
    {
        $playlist = Playlist::find($playlist_id);
        if ($playlist) {
            $exists = $playlist->playlist_song()
                ->wherePivot('song_id', $song_id)
                ->exists();

            if (!$exists) {
                return response()->json(['message' => 'Bài hát không tồn tại trong playlist'], 409);
            }

            $playlist->playlist_song()->detach($song_id);
            return response()->json(['message' => 'Xóa bài hát khỏi playlist thành công'], 200);
        } else {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }
    }
}
