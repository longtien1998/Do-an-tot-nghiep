<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function list_music(){
        return view('admin.music.list-music');
    }
    public function add_music(){
        return view('admin.music.add-music');
    }
    public function update_music(){
        return view('admin.music.update-music');
    }
}
