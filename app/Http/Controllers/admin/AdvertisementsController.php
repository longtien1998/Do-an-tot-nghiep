<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvertisementsController extends Controller
{

    public function list_advertisements(){
        return view('admin.advertisements.list-advertisements');
    }
    public function add_advertisements(){
        return view('admin.advertisements.add-advertisements');
    }
    public function update_advertisements(){
        return view('admin.advertisements.update-advertisements');
    }
}
