<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function home(){
        $total_user = User::count();
        return view('admin.dashboard', ['total_user' => $total_user]);
    }

}
