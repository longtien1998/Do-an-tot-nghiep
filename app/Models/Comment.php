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
    public static function selectCmt(){
        return DB::table('ratings')
        ->select('id',
        'user_id',
        'song_id',
        'rating',
        'comment',
        'rating_date',)
        ->whereNull('deleted_at')
        ->get();
    }
    public static function search_cmt($search)
    {
        $ratings = DB::table('ratings')
            ->where('comment', 'LIKE', '%' . $search . '%')
            ->select('ratings.*')
            ->get();
        return $ratings;
    }
}
