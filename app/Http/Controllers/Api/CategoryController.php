<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryController extends Controller
{

    public function index(){
        $categories = Categories::all();
        return response()->json($categories,200);
    }
}
