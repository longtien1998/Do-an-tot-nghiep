<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SongStatistical;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticalSongController extends Controller
{
    public function music()
    {
        $dataSong = SongStatistical::paginate(20);
        return view('admin.statistical.music', compact('dataSong'));
    }
    public function getData($date)
    {
        $startDate = Carbon::now()->subDays($date)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

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

        $labels = $data->pluck('date');
        $listen_count = $data->pluck('listen_count');
        $download_count = $data->pluck('download_count');
        $like_count = $data->pluck('like_count');

        return response()->json([
            'labels' => $labels,
            'listen_count' => $listen_count,
            'download_count' => $download_count,
            'like_count' => $like_count,
        ]);
    }

    public function getSongsByDate(Request $request)
    {
        $date = $request->input('date');
        $dataset = $request->input('dataset');  // lấy cột mình chọn

        $songs = DB::table('ranking_logs')
            ->join('songs', 'ranking_logs.song_id', '=', 'songs.id')
            ->select('songs.song_name as song_name', 'ranking_logs.listen_count', 'ranking_logs.download_count', 'ranking_logs.like_count', 'ranking_logs.date')
            ->whereDate('ranking_logs.date', $date)
            ->get();

        // lọc thông tin cột đưuọc chno
        $filteredSongs = $songs->map(function ($song) use ($dataset) {
            // gán giá trị cho cho cột đưuọc chona
            switch ($dataset) {
                case 'Lượt nghe':
                    $song->value = $song->listen_count;
                    break;
                case 'Lượt thích':
                    $song->value = $song->like_count;
                    break;
                case 'Lượt tải xuống':
                    $song->value = $song->download_count;
                    break;
                default:
                    $song->value = 0; 
            }
            return $song;
        });

        return response()->json([
            'songs' => $filteredSongs
        ]);
    }

}
