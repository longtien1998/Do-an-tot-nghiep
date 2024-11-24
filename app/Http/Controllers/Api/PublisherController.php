<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function show($id){
        $publisher = Publisher::find($id);
        if($publisher){
            return response()->json($publisher);
        }
        return response()->json(['error' => 'Publisher not found'], 404);
    }
}
