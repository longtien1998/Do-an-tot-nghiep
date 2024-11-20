<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function list_album(){
        return view('admin.album.list-album');
    }
    public function add_album(){
        return view('admin.album.add-album');
    }
    public function update_album(){
        return view('admin.album.update-album');
    }
}
