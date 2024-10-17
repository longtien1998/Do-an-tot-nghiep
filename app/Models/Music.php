<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Music extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'songs';
    protected $fillable = [
        'song_name',
        'description',
        'lyrics',
        'singers_id',
        'categories_id',
        'song_image',
        'release_date',
        'listen_count',
        'provider',
        'composer',
        'download_count',
    ];

    public static function selectAll(){
        return DB::table('songs')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->select('songs.*', 'categories.categorie_name as category_name')
            ->get();
    }

    public static function show($id)
    {

        $music = DB::table('songs')
            ->where('songs.id', $id)
            ->select('songs.*', 'categories.categorie_name as category_name')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')

            ->first(); // Lấy 1 bản ghi
        ;
        return $music;
    }
}
