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
    use HasFactory, SoftDeletes;
    protected $table = 'album_song';

    protected $fillable = [
        'album_id',
        'song_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
}
