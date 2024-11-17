<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Test;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function test(){
        $test = Test::test();
        return response()->json($test);
    }
}
