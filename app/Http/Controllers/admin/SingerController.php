<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SingerController extends Controller
{
    public function list_singer(){
        return view('admin.singer.list-singer');
    }
    public function add_singer(){
        return view('admin.singer.add-singer');
    }
    public function update_singer(){
        return view('admin.singer.update-singer');
    }
}
