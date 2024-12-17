<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(){
        $countries = Country::all();
        return response()->json($countries,200);
    }

    // public function show($id){
    //     $country = Country::find($id);
    //     if($country){
    //         return response()->json($country,200);
    //     } else {
    //         return response()->json(['message' => 'Country not found'], 404);
    //     }

    // }
}
