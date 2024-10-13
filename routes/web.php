<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\MusicController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\SingerController;
use App\Http\Controllers\admin\AlbumController;
use App\Http\Controllers\admin\CopyrightController;
use App\Http\Controllers\admin\PublishersController;
use App\Http\Controllers\admin\AdvertisementsController;







Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/dashboard', [HomeController::class, 'home'])->name('dashboard');
Route::get('/admin/list-music', [MusicController::class, 'list_music'])->name('list-music');
Route::get('/admin/add-music', [MusicController::class, 'add_music'])->name('add-music');
Route::get('/admin/update-music', [MusicController::class, 'update_music'])->name('update-music');

Route::get('/admin/list-categories', [CategoriesController::class, 'list_categories'])->name('list-categories');
Route::get('/admin/add-categories', [CategoriesController::class, 'add_categories'])->name('add-categories');
Route::get('/admin/update-categories', [CategoriesController::class, 'update_categories'])->name('update-categories');

Route::get('/admin/list-singer', [SingerController::class, 'list_singer'])->name('list-singer');
Route::get('/admin/add-singer', [SingerController::class, 'add_singer'])->name('add-singer');
Route::get('/admin/update-singer', [SingerController::class, 'update_singer'])->name('update-singer');

Route::get('/admin/list-album', [AlbumController::class, 'list_album'])->name('list-album');
Route::get('/admin/add-album', [AlbumController::class, 'add_album'])->name('add-album');
Route::get('/admin/update-album', [AlbumController::class, 'update_album'])->name('update-album');

Route::get('/admin/list-copyright', [CopyrightController::class, 'list_copyright'])->name('list-copyright');
Route::get('/admin/add-copyright', [CopyrightController::class, 'add_copyright'])->name('add-copyright');
Route::get('/admin/update-copyright', [CopyrightController::class, 'update_copyright'])->name('update-copyright');

Route::get('/admin/list-publishers', [PublishersController::class, 'list_publishers'])->name('list-publishers');
Route::get('/admin/add-publishers', [PublishersController::class, 'add_publishers'])->name('add-publishers');
Route::get('/admin/update-publishers', [PublishersController::class, 'update_publishers'])->name('update-publishers');

Route::get('/admin/list-advertisements', [AdvertisementsController::class, 'list_advertisements'])->name('list-advertisements');
Route::get('/admin/add-advertisements', [AdvertisementsController::class, 'add_advertisements'])->name('add-advertisements');
Route::get('/admin/update-advertisements', [AdvertisementsController::class, 'update_advertisements'])->name('update-advertisements');
Route::prefix('admin')->group(function () {

});
