
    <?php

    use App\Http\Controllers\Admin\LoginController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\admin\HomeController;
    use App\Http\Controllers\admin\MusicController;
    use App\Http\Controllers\admin\CountriesController;
    use App\Http\Controllers\admin\CategoriesController;
    use App\Http\Controllers\admin\SingerController;
    use App\Http\Controllers\admin\AlbumController;
    use App\Http\Controllers\admin\CopyrightController;
    use App\Http\Controllers\admin\PublishersController;
    use App\Http\Controllers\admin\ads\AdvertisementsController;
    use App\Http\Controllers\admin\ads\S3AdsController;
    use App\Http\Controllers\admin\UsersController;
    use App\Http\Controllers\admin\CommentController;
    use App\Http\Controllers\admin\S3ImageController;
    use App\Http\Controllers\admin\S3SongController;


    route::group([
        'controller' => LoginController::class,
    ], function () {
        Route::get('/login',  'index')->name('login-index');
        Route::post('/login',  'authenticate')->name('login');
        Route::post('/logout',  'logout')->name('logout');
    });
    Route::get('/test', function () {
        return view('test');
    });
    // dashboard
    Route::get('/', [HomeController::class, 'home'])->name('');
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

    // bài hát
    Route::group([
        'middleware' => ['admin'],
    ], function () {
        // songs
        Route::prefix('songs')->group(function () {
            route::controller(MusicController::class)->group(function () {
                Route::match(['get', 'post'], '/list',  'list_music')->name('list-music');
                Route::post('/search',  'search_song')->name('search-song');
                Route::get('/add',  'add_music')->name('add-music');
                Route::post('/store',  'store_music')->name('store-music');
                Route::get('/{id}/show',  'show_music')->name('show-music');
                Route::put('/{id}/update',  'update_music')->name('update-music');
                Route::delete('/{id}/delete',  'delete_music')->name('delete-music');
                Route::post('/list/delete',  'delete_list_music')->name('delete-list-music');
                // update file nhạc
                Route::put('/{id}/update-file-music',  'up_loadFile_music')->name('up-load-file-music');
                //trash
                route::prefix('trash')->group(function () {
                    Route::get('/',  'list_trash_music')->name('list-trash-music');
                    Route::post('/search',  'search_song_trash')->name('search-song-trash');
                    Route::post('/restore',  'restore_trash_music')->name('list-restore-songs');
                    Route::get('/restore-all',  'restore_all_music')->name('restore-all-songs');
                    Route::post('/delete',  'delete_trash_music')->name('list-delete-songs');
                    Route::get('/delete-all',  'delete_all_music')->name('delete-all-songs');
                    Route::get('/{id}/destroy',  'destroy_trash_music')->name('destroy-trash-songs');
                });
            });
            route::prefix('s3')->group(function () {
                // hình ảnh trên AWS S3
                Route::get('/images', [S3ImageController::class, 'image_songs'])->name('s3images.index');
                Route::post('/images', [S3ImageController::class, 'destroy_image_songs'])->name('s3images.destroy');
                Route::post('/images-destroy', [S3ImageController::class, 'list_destroy_image_songs'])->name('s3list-destroy-image-songs');
                // File nhạc trên AWS S3
                Route::get('/songs', [S3SongController::class, 'file_songs'])->name('s3songs.index');
                Route::post('/songs', [S3SongController::class, 'destroy_file_songs'])->name('s3songs.destroy');
                Route::post('/songs-destroy', [S3ImageController::class, 'list_destroy_songs'])->name('s3list-destroy-songs');
            });
        });

        // quốc gia trong bài hát
        route::prefix('countries')->controller(CountriesController::class)->group(function () {
            Route::get('/list', 'index')->name('list-country');
            Route::post('/search', 'search_country')->name('search-country');
            Route::post('/store', 'store_country')->name('store-country');
            Route::put('/{id}/update', 'update_country')->name('update-country');
            Route::delete('/{id}/delete', 'delete_country')->name('delete-country');
            Route::post('/list/delete', 'delete_list_country')->name('delete-list');

            // trash countries
            route::prefix('trash')->group(function () {
                Route::get('/', 'list_trash_country')->name('list_trash_country');
                Route::post('/search', 'search_country_trash')->name('search-country-trash');
                Route::get('/{id}/restore', 'restore_country')->name('restore_country');
                Route::post('/restore', 'restore_trash_country')->name('list-restore-countries');
                Route::get('/restore-all', 'restore_all_country')->name('restore-all-countries');
                Route::post('/destroy', 'destroy_trash_list_country')->name('list-destroy-countries');
                Route::get('/{id}/destroy', 'destroy_trash_country')->name('destroy-trash-country');
            });
        });
    });


    // danh mục
    Route::group([
        'prefix' => 'categories',
        // 'middleware' => ['auth'],
        'controller' => CategoriesController::class,
        'as' => 'categories.',
    ], function () {

        Route::get('/list',  'list_categories')->name('list');
        Route::get('/add',  'add_categories')->name('add');
        Route::post('/store',  'store_categories')->name('store');
        Route::get('/{id}/edit',  'edit_categories')->name('edit');
        Route::put('/{id}/update',  'update_categories')->name('update');
        Route::delete('/{id}/delete',  'delete_categories')->name('delete');
        Route::post('/list/delete',  'delete_list')->name('delete-list');
        Route::post('/search',  'search_categories')->name('search');

        Route::group([
            'prefix' => 'trash',
            'as' => 'trash.',
        ], function () {
            Route::get('/',  'trash_categories')->name('list');
            Route::post('/search',  'search_trash_categories')->name('search');
            Route::get('/{id}/restore', 'restore_categories')->name('restore');
            Route::post('/restore', 'restore_list_categories')->name('restore-list');
            Route::get('/restore-all', 'restore_all_categories')->name('restore-all');
            Route::get('/{id}/destroy', 'destroy_categories')->name('destroy');
            Route::post('/destroy', 'destroy_list_categories')->name('destroy-list');
        });
    });



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

    Route::get('/advertisements/create', [AdvertisementsController::class, 'add_advertisements'])->name('advertisements.create');
    Route::post('/advertisements', [AdvertisementsController::class, 'storeAdvertisements'])->name('advertisements.store');

    Route::get('/advertisements/edit/{id}', [AdvertisementsController::class, 'edit_advertisements'])->name('advertisements.edit');
    Route::put('/advertisements/update/{id}', [AdvertisementsController::class, 'update_advertisements'])->name('advertisements.update');


    Route::post('/search-advertisements', [AdvertisementsController::class, 'searchAds'])->name('searchAds');
    Route::post('/search-trash-advertisements', [AdvertisementsController::class, 'search_ads_trash'])->name('searchTrashAds');



    Route::get('/s3ads/show', [S3AdsController::class, 'file_ads'])->name('s3ads.index');
    Route::post('/s3ads', [S3AdsController::class, 'destroy_file_ads'])->name('s3ads.destroy');


    Route::delete('/delete-advertisements/{id}', [AdvertisementsController::class, 'delete_advertisements'])->name('delete-advertisements');
    Route::post('/list/delete-advertisements', [AdvertisementsController::class, 'delete_list_ads'])->name('delete_list_ads');

    Route::get('/list-trash-advertisements', [AdvertisementsController::class, 'list_trash_ads'])->name('list_trash_ads');


    Route::post('/restore-advertisements', [AdvertisementsController::class, 'restore_trash_ads'])->name('restore_trash_ads');
    Route::get('/restore-all-advertisements', [AdvertisementsController::class, 'restore_all_ads'])->name('restore_all_ads');

    Route::post('/delete-advertisements', [AdvertisementsController::class, 'delete_trash_ads'])->name('delete_trash_ads');
    Route::get('/delete-all-advertisements', [AdvertisementsController::class, 'delete_all_ads'])->name('delete_all_ads');

    Route::get('/destroy-trash-advertisements/{id}', [AdvertisementsController::class, 'destroy_trash_ads'])->name('destroy_trash_ads');



//Users

Route::get('/list-users', [UsersController::class, 'list_users'])->name('list-users');

Route::get('/add-users', [UsersController::class, 'add_users'])->name('add-users');
Route::post('/add-users', [UsersController::class, 'storeAddUser'])->name('store-addUsers');

Route::get('/delete-users/{id}', [UsersController::class, 'delete_users'])->name('delete-users');

Route::get('/update-users/{id}', [UsersController::class, 'update_users'])->name('update-users');
Route::put('/update-users/{id}', [UsersController::class, 'storeUpdate'])->name('store-updateUsers');

Route::get('/list-trash-users', [UsersController::class, 'list_trash_users'])->name('list_trash_users');

Route::post('/search-users', [UsersController::class, 'searchUser'])->name('searchUser');
Route::post('/search-trash-users', [UsersController::class, 'search_users_trash'])->name('searchTrashUser');



Route::delete('/delete-users/{id}', [UsersController::class, 'delete_users'])->name('delete-users');
Route::post('/list/delete-users', [UsersController::class, 'delete_list_users'])->name('delete_list_users');

Route::get('/list-trash-users', [UsersController::class, 'list_trash_users'])->name('list_trash_users');


Route::post('/restore-users', [UsersController::class, 'restore_trash_users'])->name('restore_trash_users');
Route::get('/restore-all-users', [UsersController::class, 'restore_all_users'])->name('restore_all_users');

Route::post('/delete-users', [UsersController::class, 'delete_trash_users'])->name('delete_trash_users');
Route::get('/delete-all-users', [UsersController::class, 'delete_all_users'])->name('delete_all_users');

Route::get('/destroy-trash-users/{id}', [UsersController::class, 'destroy_trash_users'])->name('destroy_trash_users');

Route::get('/show-user/{id}', [UsersController::class, 'show_user'])->name('show_users');



//Comments

Route::get('/list-comments', [CommentController::class, 'list_comments'])->name('list-comments');

Route::delete('/delete-comments/{id}', [CommentController::class, 'delete_comments'])->name('delete-comments');

Route::get('/update_comments/{id}', [CommentController::class, 'update_comments'])->name('update_comments');
Route::put('/update_comments/{id}', [CommentController::class, 'storeComment'])->name('store_comments');

Route::get('/list-trash-comments', [CommentController::class, 'list_trash_comments'])->name('list_trash_comments');

Route::post('/search-comments', [CommentController::class, 'searchComments'])->name('searchComments');
Route::post('/search-trash-comments', [CommentController::class, 'search_comments_trash'])->name('searchTrashComments');

Route::post('/list/delete-comments', [CommentController::class, 'delete_list_comments'])->name('delete_list_comments');

Route::post('/restore-comments', [CommentController::class, 'restore_trash_comments'])->name('restore_trash_comments');
Route::get('/restore-all-comments', [CommentController::class, 'restore_all_comments'])->name('restore_all_comments');

Route::post('/delete-comments', [CommentController::class, 'delete_trash_comments'])->name('delete_trash_comments');
Route::get('/delete-all-comments', [CommentController::class, 'delete_all_comments'])->name('delete_all_comments');

Route::get('/destroy-trash-comments/{id}', [CommentController::class, 'destroy_trash_comments'])->name('destroy_trash_comments');



