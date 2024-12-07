<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\FavouriteSinger;
use Illuminate\Http\Request;

class FavouriteSingerController extends Controller
{


    public function getAll($user_id){
        $singers = FavouriteSinger::where('user_id', $user_id)->get()->pluck('singer_id');
        return response()->json(['data' => $singers], 200);
    }


    public function checkFavourite($user_id,$singer_id){
        $isFavourite = FavouriteSinger::where('user_id', $user_id)->where('singer_id', $singer_id)->exists();
        return response()->json([$isFavourite], 200);

    }
}