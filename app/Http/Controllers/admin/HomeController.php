<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Music;
use App\Models\Publisher;
use App\Models\Singer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Album;
use App\Models\Payment;
use App\Models\Country;
use App\Models\Advertisements;
use App\Models\Copyright;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
        $total_albums = Album::count();
        $total_amount = Payment::sum('amount');
        $total_order = Payment::count();
        $total_country = Country::count();
        $total_ads = Advertisements::count();
        $total_copyright = Copyright::count();
        return view('admin.dashboard', [
            'total_user' => $total_user,
            'total_song' => $total_song,
            'total_singer' => $total_singer,
            'total_category' => $total_category,
            'total_comment' => $total_comment,
            'total_publishers' => $total_publishers,
            'total_albums' => $total_albums,
            'total_amount' => $total_amount,
            'total_order' => $total_order,
            'total_country' => $total_country,
            'total_ads' => $total_ads,
            'total_copyright' => $total_copyright,
            'user' => Auth::user()
        ]);
    }
    public function getData($date)
    {
        // dd($request->all());
        $startDate = Carbon::now()->subDays($date)->startOfDay(); // 20 ngày trước
        $endDate = Carbon::now()->endOfDay(); // Ngày hiện tại

        // Lấy dữ liệu từ cơ sở dữ liệu
        $data = DB::table('ranking_logs')
            ->select(
                DB::raw('DATE(date) as date'),
                DB::raw('SUM(listen_count) as listen_count'),
                DB::raw('SUM(download_count) as download_count'),
                DB::raw('SUM(like_count) as like_count')
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $labels = $data->pluck('date');
        $listen_count = $data->pluck('listen_count');
        $download_count = $data->pluck('download_count');
        $like_count = $data->pluck('like_count');
        // dd($labels);
        return response()->json([
            'labels' => $labels,
            'listen_count' => $listen_count,
            'download_count' => $download_count,
            'like_count' => $like_count,
        ]);
    }
    public function getUser($date)
    {
        // dd($request->all());
        $startDate = Carbon::now()->subDays($date)->startOfDay(); // 20 ngày trước
        $endDate = Carbon::now()->endOfDay(); // Ngày hiện tại

        // Lấy dữ liệu từ cơ sở dữ liệu
        $data = DB::table('users')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(id) as create_count')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $labels = $data->pluck('date');
        $create_count = $data->pluck('create_count');
        // dd($labels);
        return response()->json([
            'labels' => $labels,
            'create_count' => $create_count,
        ]);
    }
    public function getPay($date)
    {
        // dd($request->all());
        $startDate = Carbon::now()->subDays($date)->startOfDay(); // 20 ngày trước
        $endDate = Carbon::now()->endOfDay(); // Ngày hiện tại

        // Lấy dữ liệu từ cơ sở dữ liệu
        $data = DB::table('payments')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as amount')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $labels = $data->pluck('date');
        $amount = $data->pluck('amount');
        // dd($labels);
        return response()->json([
            'labels' => $labels,
            'amount' => $amount,
        ]);
    }
}
