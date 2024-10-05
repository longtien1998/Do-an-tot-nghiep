<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublishersController extends Controller
{

    public function list_publishers(){
        return view('admin.publishers.list-publishers');
    }
    public function add_publishers(){
        return view('admin.publishers.add-publishers');
    }
    public function update_publishers(){
        return view('admin.publishers.update-publishers');
    }
}
