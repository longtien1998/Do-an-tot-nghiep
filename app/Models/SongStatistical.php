<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongStatistical extends Model
{
    protected $table = 'ranking_logs';
    protected $casts = [
        'date' => 'datetime',
    ];
    protected $fillable = [
        'id',
        'song_id',
        'listen_count',
        'download_count',
        'like_count',
        'date',
        'created_at'
    ];

    public function song(){
        return $this->belongsTo(Music::class, 'song_id');
    }
}
