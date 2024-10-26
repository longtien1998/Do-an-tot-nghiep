<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\MusicController;
use App\Http\Controllers\admin\CountriesController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\SingerController;
use App\Http\Controllers\admin\AlbumController;
use App\Http\Controllers\admin\CopyrightController;
use App\Http\Controllers\admin\PublishersController;
use App\Http\Controllers\admin\AdvertisementsController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\S3ImageController;
use App\Http\Controllers\admin\S3SongController;







Route::get('/test', function () {
    return view('admin.music.url-music');
});
Route::get('/', [HomeController::class, 'home'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

// songs
Route::prefix('songs')->group(function () {
    Route::match(['get', 'post'],'/list', [MusicController::class, 'list_music'])->name('list-music');

    Route::post('/search', [MusicController::class, 'search_song'])->name('search-song');

    Route::get('/add', [MusicController::class, 'add_music'])->name('add-music');
    Route::post('/store', [MusicController::class, 'store_music'])->name('store-music');

    Route::get('/{id}/show', [MusicController::class, 'show_music'])->name('show-music');
    Route::put('/{id}/update', [MusicController::class, 'update_music'])->name('update-music');

    Route::delete('/{id}/delete', [MusicController::class, 'delete_music'])->name('delete-music');
    Route::post('/list/delete', [MusicController::class, 'delete_list_music'])->name('delete-list-music');


    // quốc gia trong bài hát
    route::prefix('countries')->group(function () {
        Route::get('/list', [CountriesController::class, 'index'])->name('list-country');

        Route::post('/search', [CountriesController::class, 'search_country'])->name('search-country');

        Route::post('/store', [CountriesController::class, 'store_country'])->name('store-country');

        Route::put('/{id}/update', [CountriesController::class, 'update_country'])->name('update-country');

        Route::delete('/{id}/delete', [CountriesController::class, 'delete_country'])->name('delete-country');
        Route::post('/list/delete', [CountriesController::class, 'delete_list_country'])->name('delete-list');
    });


    route::prefix('trash')->group(function () {
        Route::get('/', [MusicController::class, 'list_trash_music'])->name('list-trash-music');

        Route::post('/search', [MusicController::class, 'search_song_trash'])->name('search-song-trash');

        Route::post('/restore', [MusicController::class, 'restore_trash_music'])->name('list-restore-songs');
        Route::get('/restore-all', [MusicController::class, 'restore_all_music'])->name('restore-all-songs');

        Route::post('/delete', [MusicController::class, 'delete_trash_music'])->name('list-delete-songs');
        Route::get('/delete-all', [MusicController::class, 'delete_all_music'])->name('delete-all-songs');

        Route::get('/{id}/destroy', [MusicController::class, 'destroy_trash_music'])->name('destroy-trash-songs');
    });

    // hình ảnh trên AWS S3
    Route::get('/s3-images', [S3ImageController::class, 'image_songs'])->name('s3images.index');
    Route::post('/s3-images', [S3ImageController::class, 'destroy_image_songs'])->name('s3images.destroy');
    // File nhạc trên AWS S3
    Route::get('/s3songs', [S3SongController::class, 'file_songs'])->name('s3songs.index');
    Route::post('/s3songs', [S3SongController::class, 'destroy_file_songs'])->name('s3songs.destroy');
});


Route::get('/create-music', [MusicController::class, 'create'])->name('create-music');

// danh mục
Route::get('/list-categories', [CategoriesController::class, 'list_categories'])->name('list-categories');
Route::get('/add-categories', [CategoriesController::class, 'add_categories'])->name('add-categories');
Route::post('/store-categories', [CategoriesController::class, 'store_categories'])->name('store-categories');
Route::get('/edit-categories/{id}', [CategoriesController::class, 'edit_categories'])->name('edit-categories');
Route::put('/update-categories/{id}', [CategoriesController::class, 'update_categories'])->name('update-categories');
Route::delete('/delete-categories/{id}', [CategoriesController::class, 'delete_categories'])->name('delete-categories');

Route::get('/list-singer', [SingerController::class, 'list_singer'])->name('list-singer');
Route::get('/add-singer', [SingerController::class, 'add_singer'])->name('add-singer');
Route::get('/update-singer', [SingerController::class, 'update_singer'])->name('update-singer');

Route::get('/list-album', [AlbumController::class, 'list_album'])->name('list-album');
Route::get('/add-album', [AlbumController::class, 'add_album'])->name('add-album');
Route::get('/update-album', [AlbumController::class, 'update_album'])->name('update-album');

Route::get('/list-copyright', [CopyrightController::class, 'list_copyright'])->name('list-copyright');
Route::get('/add-copyright', [CopyrightController::class, 'add_copyright'])->name('add-copyright');
Route::get('/update-copyright', [CopyrightController::class, 'update_copyright'])->name('update-copyright');

Route::get('/list-publishers', [PublishersController::class, 'list_publishers'])->name('list-publishers');
Route::get('/add-publishers', [PublishersController::class, 'add_publishers'])->name('add-publishers');
Route::get('/update-publishers', [PublishersController::class, 'update_publishers'])->name('update-publishers');

//advertisements

Route::get('/list-advertisements', [AdvertisementsController::class, 'list_advertisements'])->name('list-advertisements');

Route::get('/add-advertisements', [AdvertisementsController::class, 'add_advertisements'])->name('add-advertisements');
Route::post('/add-advertisements', [AdvertisementsController::class, 'storeAdvertisements'])->name('store-advertisements');

Route::get('/update-advertisements/{id}', [AdvertisementsController::class, 'update_advertisements'])->name('update-advertisements');
Route::put('/update-advertisements/{id}', [AdvertisementsController::class, 'storeUpdate'])->name('store-advertisements');

Route::post('/search-advertisements', [AdvertisementsController::class, 'searchAds'])->name('searchAds');



Route::delete('/delete-advertisements/{id}', [AdvertisementsController::class, 'delete_advertisements'])->name('delete-advertisements');
Route::post('/list/delete-advertisements', [AdvertisementsController::class, 'delete_list_ads'])->name('delete_list_ads');

Route::get('/list-trash-advertisements', [AdvertisementsController::class, 'list_trash_ads'])->name('list_trash_ads');


Route::post('/restore-advertisements', [AdvertisementsController::class, 'restore_trash_ads'])->name('restore_trash_ads');
Route::get('/restore-all-advertisements', [AdvertisementsController::class, 'restore_all_ads'])->name('restore_all_ads');

Route::post('/delete-advertisements', [AdvertisementsController::class, 'delete_trash_ads'])->name('delete_trash_ads');
Route::get('/delete-all-advertisements', [AdvertisementsController::class, 'delete_all_ads'])->name('delete_all_ads');

Route::get('/destroy-trash-advertisements/{id}', [AdvertisementsController::class, 'destroy_trash_ads'])->name('destroy_trash_ads');




Route::get('/list-users', [UsersController::class, 'list_users'])->name('list-users');
Route::get('/add-users', [UsersController::class, 'add_users'])->name('add-users');
Route::post('/add-users', [UsersController::class, 'storeAddUser'])->name('store-addUsers');
Route::get('/delete-users/{id}', [UsersController::class, 'delete_users'])->name('delete-users');
Route::get('/update-users/{id}', [UsersController::class, 'update_users'])->name('update-users');
Route::put('/update-users/{id}', [UsersController::class, 'storeUpdate'])->name('store-updateUsers');

Route::get('/list-comments', [CommentController::class, 'list_comments'])->name('list-comments');
Route::get('/delete-comments/{id}', [CommentController::class, 'delete_comments'])->name('delete-comments');
Route::get('/update_comments/{id}', [CommentController::class, 'update_comments'])->name('update_comments');
Route::put('/update_comments/{id}', [CommentController::class, 'storeComment'])->name('store_comments');
