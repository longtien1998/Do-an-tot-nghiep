<?php

namespace App\Models;

use App\Models\Api\Songs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class AlbumSongs extends Model
{
    use HasFactory;
    protected $table = 'album_song';

    protected $fillable = [
        'album_id',
        'song_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function song(){
        return $this->belongsTo(Songs::class,'song_id','id');
    }
    public function album(){
        return $this->belongsTo(Album::class,'album_id','id');
    }

    public static function selectAll(){
        
    }
}
