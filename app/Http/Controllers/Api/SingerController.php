<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Singer;
use Illuminate\Http\Request;

class SingerController extends Controller
{
    public function index(){
        $singers = Singer::all();

        return response()->json($singers, 200);
    }
}
