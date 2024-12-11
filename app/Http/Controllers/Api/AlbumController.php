<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function album_singer($id){
        $albums = Album::where('singer_id','=', $id)->get();
        return response()->json($albums, 200);
    }
}
