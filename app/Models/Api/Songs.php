<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Songs extends Model
{
    use HasFactory;
    protected $table ='songs';
    protected $primaryKey = 'id';
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

    public static function bxh_100(){
        $songsList = DB::table('songs')
            ->join('categories', 'songs.categories_id', '=', 'categories.id')
            ->join('file_paths', 'songs.id', '=', 'file_paths.song_id')
            ->select('songs.*', 'categories.categorie_name as category_name','file_paths.file_path as file_path')
            ->whereNull('songs.deleted_at') // Chỉ lấy những bản ghi chưa bị soft delete
            ->orderBy('songs.listen_count', 'desc') // Sắp xếp theo số lượt nghe giảm dần
            // ->get();
            ->paginate(100);
            return $songsList;
    }

    
}
