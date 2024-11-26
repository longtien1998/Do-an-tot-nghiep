<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Playlist_song extends Model
{
    protected $table = 'playlist_song';
    protected $fillable = [
        'playlist_id',
       'song_id',
    ];

    public function playlist(){
        return $this->belongsTo(Playlist::class, 'playlist_id', 'id');
    }

    public function song(){
        return $this->belongsTo(Songs::class, 'song_id','id');
    }
}
