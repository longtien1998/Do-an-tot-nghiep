<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Comment;
use App\Models\Music;
use App\Models\Singer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function home()
    {
        $total_user = User::count();
        $total_song = Music::count();
        $total_singer = Singer::count();
        $total_category = Categories::count();
        $total_comment = Comment::count();
        $total_singer = Singer::count();

        return view('admin.dashboard', [
            'total_user' => $total_user,
            'total_song' => $total_song,
            'total_singer' => $total_singer,
            'total_category' => $total_category,
            'total_comment' => $total_comment,
            'user' => Auth::user()
        ]);
    }
}
