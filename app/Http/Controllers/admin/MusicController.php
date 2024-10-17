<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Response;
use App\Models\Music;

class MusicController extends Controller
{
    public function list_music()
    {
        $songs = Music::selectAll();
        return view('admin.music.list-music',compact('songs'));
    }
    public function add_music()
    {
        return view('admin.music.add-music');
    }

    public function edit_music(){
        return view('admin.music.edit-music');
    }
    public function show_music($id)
    {
        $song = Music::show($id);
        dd($song);
        return view('admin.music.show-music');
    }
    public function store_music(Request $request)
    {
        // Validate file MP3
        $request->validate([
            'music_file' => 'required|mimes:mp3|max:20480', // 20MB
        ]);

        // Upload file lên Amazon S3
        $path = $request->file('music_file')->store('music', 's3');
        Storage::disk('s3')->setVisibility($path, 'public');
        $url = Storage::disk('s3')->url($path);


        // Chuyển hướng lại form với URL để hiển thị nhạc
        return back()->with('music_url', $url);
    }

    public function update_music()
    {
        return view('admin.music.update-music');
    }
    public function delete_music()
    {
        return view('admin.music.delete-music');
    }
    public function search_music()
    {
        return view('admin.music.search-music');
    }
}
