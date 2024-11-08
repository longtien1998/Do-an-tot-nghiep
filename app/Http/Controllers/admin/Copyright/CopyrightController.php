<?php

namespace App\Http\Controllers\admin\Copyright;

use App\Http\Controllers\Controller;
use App\Models\CopyrightModel;
use Illuminate\Http\Request;

class CopyrightController extends Controller
{
    public function index(){
        
        $copyrights = CopyrightModel::paginate(10);
        // dd($copyrights);
        return view('admin.copyright.index', compact('copyrights'));
    }

    public function create(){
        return view('admin.copyright.create');
    }
    public function store(Request $request){

    }
}
