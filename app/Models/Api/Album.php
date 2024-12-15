<?php

namespace App\Models\Api;

use App\Models\Singer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    protected $fillable = [
        'album_name',
        'singer_id',
        'image',
        'listen_count',
        'creation_date',
    ];
    public function favourite()
    {
        return $this->belongsToMany(User::class, 'favorite_album', 'album_id', 'user_id');
    }
    public function singer()
    {
        return $this->belongsTo(Singer::class, 'singer_id');
    }
}
