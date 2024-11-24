<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteAlbum extends Model
{
    use HasFactory;

    protected $table = 'favorite_album';

    protected $fillable = [
        'user_id',
        'album_id',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
