<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function list_categories(){
        return view('admin.categories.list-categories');
    }
    public function add_categories(){
        return view('admin.categories.add-categories');
    }
    public function update_categories(){
        return view('admin.categories.update-categories');
    }
}
