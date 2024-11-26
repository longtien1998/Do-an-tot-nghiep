<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends Model
{
    protected $table = 'playlists';
    protected $fillable = [
        'playlist_name',
        'share',
        'user_id',
        'created_at',
        'updated_at',
    ];
    public function playlist_song():BelongsToMany {
        return $this->belongsToMany(Songs::class, 'playlist_song', 'playlist_id','song_id');
    }
}
