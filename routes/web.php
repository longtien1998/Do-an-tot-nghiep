<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/dashboard', [HomeController::class, 'home'])->name('dashboard');
Route::get('/admin/list-music', [HomeController::class, 'list_music'])->name('list-music');
Route::get('/admin/add-music', [HomeController::class, 'add_music'])->name('add-music');
Route::get('/admin/update-music', [HomeController::class, 'update_music'])->name('update-music');


