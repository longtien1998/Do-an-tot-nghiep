<?php

namespace App\Http\Controllers\admin\music;

use App\Http\Controllers\Controller;
use App\Models\Music;
use Illuminate\Http\Request;

class UrlsongController extends Controller
{
    public function index(Request $request){
        $perPage = 10;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
        }
        $urls = Music::url($perPage);
        // dd($url);
        return view('admin.music.url.url-music',compact('urls'));
    }
}
