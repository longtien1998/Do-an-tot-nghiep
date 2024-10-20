<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;

class Music extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'songs';
    protected $primaryKey  = 'id';
    protected $fillable = [
        'id',
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

    public static function selectAll()
    {
        $songsList = DB::table('songs')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->select('songs.*', 'categories.categorie_name as category_name')
            ->whereNull('songs.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            ->get();

        // return DB::table('songs')
        //     ->join('categories', 'songs.categories_id', '=', 'categories.id')
        //     ->select('songs.*', 'categories.categorie_name as category_name')
        //     ->get();
        // return songs::with('category')->first();// Lấy tất cả bản ghi
        return $songsList;
    }

    public static function show($id)
    {

        $music = DB::table('songs')
            ->where('songs.id', $id)
            ->select('songs.*', 'categories.categorie_name as category_name')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->whereNull('songs.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            ->first(); // Lấy 1 bản ghi
        ;
        return $music;
    }
}
