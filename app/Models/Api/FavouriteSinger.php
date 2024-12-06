<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class FavouriteSinger extends Model
{
    protected $table = 'favorite_singer';
    protected $fillable = ['user_id','singer_id'];
}
