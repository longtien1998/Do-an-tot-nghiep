<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteSong extends Model
{
    use HasFactory;
    protected $table = 'favorite_song';
    protected $fillable = [
        'user_id',
        'song_id',
    ];
}
