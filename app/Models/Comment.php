<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ratings';
    protected $fillable = [
        'user_id',
        'song_id',
        'rating',
        'comment',
        'rating_date',
    ];
    public static function selectCmt()
    {
        return Self::with(['user', 'song'])->orderByDesc('id')->paginate(10);
    }
    public static function search_cmt($search)
    {
        $ratings = DB::table('ratings')
            ->where('comment', 'LIKE', '%' . $search . '%')
            ->orWhere('rating', 'LIKE', '%' . $search . '%')
            ->orWhere('rating_date', 'LIKE', '%' . $search . '%')
            ->select('ratings.*')
            ->paginate(10);
        return Comment::whereIn('id', $ratings->pluck('id'))->with(['user', 'song'])->paginate(10);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function song()
    {
        return $this->belongsTo(Music::class);
    }
}
