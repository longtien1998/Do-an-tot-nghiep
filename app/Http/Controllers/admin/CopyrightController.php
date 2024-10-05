<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CopyrightController extends Controller
{
    public function list_copyright(){
        return view('admin.copyright.list-copyright');
    }
    public function add_copyright(){
        return view('admin.copyright.add-copyright');
    }
    public function update_copyright(){
        return view('admin.copyright.update-copyright');
    }
}
