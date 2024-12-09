<?php

namespace App\Models\Api;

use App\Models\Singer;
use Illuminate\Database\Eloquent\Model;

class FavouriteSinger extends Model
{
    protected $table = 'favorite_singer';
    protected $fillable = ['user_id','singer_id'];

    public function singer(){
        return $this->belongsTo(Singer::class, 'singer_id');
    }
}
