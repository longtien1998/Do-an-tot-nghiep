<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Music;
use App\Models\Publisher;
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
        $total_category = Category::count();
        $total_comment = Comment::count();
        $total_singer = Singer::count();
        $total_publishers = Publisher::count();

        return view('admin.dashboard', [
            'total_user' => $total_user,
            'total_song' => $total_song,
            'total_singer' => $total_singer,
            'total_category' => $total_category,
            'total_comment' => $total_comment,
            'total_publishers' => $total_publishers,
            'user' => Auth::user()
        ]);
    }
}
