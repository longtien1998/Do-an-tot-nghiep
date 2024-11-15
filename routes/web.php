
    <?php

    use App\Http\Controllers\admin\LoginController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\admin\HomeController;
    use App\Http\Controllers\admin\music\MusicController;
    use App\Http\Controllers\admin\CountriesController;
    use App\Http\Controllers\admin\CategoriesController;
    use App\Http\Controllers\admin\SingerController;
    use App\Http\Controllers\admin\AlbumController;
    use App\Http\Controllers\admin\Copyright\CopyrightController;
    use App\Http\Controllers\admin\Publisher\PublishersController;
    use App\Http\Controllers\admin\ads\AdvertisementsController;
    use App\Http\Controllers\admin\ads\S3AdsController;
    use App\Http\Controllers\admin\UsersController;
    use App\Http\Controllers\admin\CommentController;
    use App\Http\Controllers\admin\music\S3ImageController;
    use App\Http\Controllers\admin\music\S3SongController;
    use App\Http\Controllers\admin\music\UrlsongController;



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


    Route::group([
        'middleware' => ['admin'],
    ], function () {

        // bài hát
        Route::group([
            'prefix' => 'songs',
        ], function () {
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
                // url
                Route::group([
                    'prefix' => 'url',
                    'as' => 'url.',
                    'controller' => UrlsongController::class,
                ], function () {
                    Route::match(['get', 'post'], '/list',  'index')->name('index');
                    Route::post('/store',  'store')->name('store');
                    Route::put('/{id}/update',  'update')->name('update');
                    Route::delete('/{id}/delete',  'destroy')->name('destroy');
                });
                //trash
                route::prefix('trash')->group(function () {
                    Route::match(['get', 'post'], '/',  'list_trash_music')->name('list-trash-music');
                    Route::post('/search',  'search_song_trash')->name('search-song-trash');
                    Route::post('/restore',  'restore_trash_music')->name('list-restore-songs');
                    Route::get('/restore-all',  'restore_all_music')->name('restore-all-songs');
                    Route::post('/delete',  'delete_trash_music')->name('list-delete-songs');
                    Route::get('/delete-all',  'delete_all_music')->name('delete-all-songs');
                    Route::get('/{id}/destroy',  'destroy_trash_music')->name('destroy-trash-songs');
                });

                // check validation
                Route::group([
                    'prefix' => 'validate',
                    'as' => 'validate.',
                ], function(){
                    Route::post('name','validate_name')->name('name');
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
        route::group([
            'prefix' => 'countries',
            'controller' => CountriesController::class,
        ], function () {
            Route::match(['get', 'post'], '/list', 'index')->name('list-country');
            Route::post('/search', 'search_country')->name('search-country');
            Route::post('/store', 'store_country')->name('store-country');
            Route::put('/{id}/update', 'update_country')->name('update-country');
            Route::delete('/{id}/delete', 'delete_country')->name('delete-country');
            Route::post('/list/delete', 'delete_list_country')->name('delete-list');

            // trash countries
            route::prefix('trash')->group(function () {
                Route::match(['get', 'post'], '/', 'list_trash_country')->name('list_trash_country');
                Route::post('/search', 'search_country_trash')->name('search-country-trash');
                Route::get('/{id}/restore', 'restore_country')->name('restore_country');
                Route::post('/restore', 'restore_trash_country')->name('list-restore-countries');
                Route::get('/restore-all', 'restore_all_country')->name('restore-all-countries');
                Route::post('/destroy', 'destroy_trash_list_country')->name('list-destroy-countries');
                Route::get('/{id}/destroy', 'destroy_trash_country')->name('destroy-trash-country');
            });
        });

        // danh mục

        Route::group([
            'prefix' => 'categories',
            'middleware' => ['admin'],
            'controller' => CategoriesController::class,
            'as' => 'categories.',
        ], function () {

            Route::match(['get', 'post'], '/list',  'list_categories')->name('list');
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
                Route::match(['get', 'post'], '/',  'trash_categories')->name('list');
                Route::post('/search',  'search_trash_categories')->name('search');
                Route::get('/{id}/restore', 'restore_categories')->name('restore');
                Route::post('/restore', 'restore_list_categories')->name('restore-list');
                Route::get('/restore-all', 'restore_all_categories')->name('restore-all');
                Route::get('/{id}/destroy', 'destroy_categories')->name('destroy');
                Route::post('/destroy', 'destroy_list_categories')->name('destroy-list');
            });
        });

        // nhà xuất bản
        Route::group([
            'prefix' => 'publishers',
            'controller' => PublishersController::class,
            'as' => 'publishers.',
        ], function () {
            Route::match(['get', 'post'], '/',  'index')->name('index');
            Route::post('/search',  'search')->name('search');
            Route::get('/create',  'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}/edit',  'edit')->name('edit');
            Route::put('/{id}/update',  'update')->name('update');
            Route::delete('/{id}/delete',  'delete')->name('delete');
            Route::post('/delete-list',  'delete_list')->name('delete-list');


            Route::group([
                'prefix' => 'trash',
                'as' => 'trash.',
            ],function () {
                Route::match(['get', 'post'], '/',  'trash')->name('index');
                Route::post('/search',  'search_trash_publishers')->name('search');
                Route::get('/{id}/restore', 'restore_publishers')->name('restore');
                Route::post('/restore', 'restore_list_publishers')->name('restore-list');
                Route::get('/restore-all', 'restore_all_publishers')->name('restore-all');
                Route::get('/{id}/destroy', 'destroy_publishers')->name('destroy');
                Route::post('/destroy', 'destroy_list_publishers')->name('destroy-list');
            });


            Route::get('/file-logo','file')->name('file');
            Route::post('/destroy-logo', 'destroy_file')->name('destroy_file');
            Route::post('/list-destroy-logo', 'list_destroy_file')->name('destroy-list-logo');
        });


        // Copyright
        Route::group([
            'prefix' => 'copyrights',
            'controller' => CopyrightController::class,
            'as' => 'copyrights.',
        ], function () {
            Route::match(['get', 'post'], '/',  'index')->name('index');
            Route::post('/search',  'search')->name('search');
            Route::get('/create',  'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}/edit',  'edit')->name('edit');
            Route::put('/{id}/update',  'update')->name('update');
            Route::delete('/{id}/delete',  'delete')->name('delete');
            Route::post('/delete-list',  'delete_list')->name('delete-list');

            Route::group([
                'prefix' => 'trash',
                'as' => 'trash.',
            ], function () {
                Route::match(['get', 'post'], '/',  'trash')->name('index');
                Route::post('/search',  'search_trash_copyrights')->name('search');
                Route::get('/{id}/restore', 'restore_copyrights')->name('restore');
                Route::post('/restore', 'restore_list_copyrights')->name('restore-list');
                Route::get('/restore-all', 'restore_all_copyrights')->name('restore-all');
                Route::get('/{id}/destroy', 'destroy_copyrights')->name('destroy');
                Route::post('/destroy', 'destroy_list_copyrights')->name('destroy-list');
            });

            Route::get('/file','file')->name('file');
        });
    }); // đóng group midle login






    Route::get('/list-singer', [SingerController::class, 'list_singer'])->name('list-singer');
    Route::get('/add-singer', [SingerController::class, 'add_singer'])->name('add-singer');
    Route::get('/update-singer', [SingerController::class, 'update_singer'])->name('update-singer');

    Route::get('/list-album', [AlbumController::class, 'list_album'])->name('list-album');
    Route::get('/add-album', [AlbumController::class, 'add_album'])->name('add-album');
    Route::get('/update-album', [AlbumController::class, 'update_album'])->name('update-album');


    //advertisements
    Route::group([
        'middleware' => ['admin'],
    ], function () {
        Route::group([
            'prefix' => 'advertisements',
            'controller' => AdvertisementsController::class,
            'as' => 'advertisements.',
        ], function () {
            Route::match(['get', 'post'], '/list',  'list_advertisements')->name('list');
            Route::get('/create',  'add_advertisements')->name('create');
            Route::post('/store',  'storeAdvertisements')->name('store');
            Route::get('/{id}/edit',  'edit_advertisements')->name('edit');
            Route::put('/{id}/update',  'update_advertisements')->name('update');
            Route::post('/search',  'searchAds')->name('search');
            Route::delete('/{id}/delete',  'delete_advertisements')->name('delete');
            Route::post('/delete-list',  'delete_list_ads')->name('delete-list');
            Route::prefix('s3')->group(function () {
                Route::get('/s3ads/show', [S3AdsController::class, 'file_ads'])->name('s3ads.index');
                Route::post('/s3ads', [S3AdsController::class, 'destroy_file_ads'])->name('s3ads.destroy');
            });
            Route::group([
                'prefix' => 'trash',
                'as' => 'trash.',
            ], function () {
                Route::get('/list',  'list_trash_ads')->name('list');
                Route::post('/search',  'search_ads_trash')->name('search');
                Route::post('/restore',  'restore_trash_ads')->name('restore');
                Route::get('/restore-all',  'restore_all_ads')->name('restore-all');
                Route::post('/delete',  'delete_trash_ads')->name('delete');
                Route::get('/delete-all',  'delete_all_ads')->name('delete-all');
                Route::get('/{id}/destroy',  'destroy_trash_ads')->name('destroy');

            });

        });


        //Users
        Route::group([
            'prefix' => 'users',
            'controller' => UsersController::class,
            'as' => 'users.',
        ], function () {
            Route::match(['get', 'post'], '/list',  'list_users')->name('list');
            Route::get('/create',  'add_users')->name('create');
            Route::post('/store',  'storeAddUser')->name('store');
            Route::get('/{id}/edit',  'edit_users')->name('edit');
            Route::put('/{id}/update',  'update_users')->name('update');
            Route::post('/search',  'searchUser')->name('search');
            Route::delete('/{id}/delete',  'delete_users')->name('delete');
            Route::post('/delete-list',  'delete_list_users')->name('delete-list');
            Route::get('/{id}/show',  'show_user')->name('show');
            Route::group([
                'prefix' => 'trash',
                'as' => 'trash.',
            ], function () {
                Route::get('/list',  'list_trash_users')->name('list');
                Route::post('/search',  'search_users_trash')->name('search');
                Route::post('/restore',  'restore_trash_users')->name('restore');
                Route::get('/restore-all',  'restore_all_users')->name('restore-all');
                Route::post('/delete',  'delete_trash_users')->name('delete');
                Route::get('/delete-all',  'delete_all_users')->name('delete-all');
                Route::get('/{id}/destroy',  'destroy_trash_users')->name('destroy');

            });

        });

        //Comments
        Route::group([
            'prefix' => 'comments',
            'controller' => CommentController::class,
            'as' => 'comments.',
        ], function () {
            Route::match(['get', 'post'], '/list',  'list_comments')->name('list');
            // Route::get('/create',  'add_users')->name('create');
            // Route::post('/store',  'storeAddUser')->name('store');
            Route::get('/{id}/edit',  'edit_comments')->name('edit');
            Route::put('/{id}/update',  'update_comments')->name('update');
            Route::post('/search',  'searchComments')->name('search');
            Route::delete('/{id}/delete',  'delete_comments')->name('delete');
            Route::post('/delete-list',  'delete_list_comments')->name('delete-list');
            Route::group([
                'prefix' => 'trash',
                'as' => 'trash.',
            ], function () {
                Route::get('/list',  'list_trash_comments')->name('list');
                Route::post('/search',  'search_comments_trash')->name('search');
                Route::post('/restore',  'restore_trash_comments')->name('restore');
                Route::get('/restore-all',  'restore_all_comments')->name('restore-all');
                Route::post('/delete',  'delete_trash_comments')->name('delete');
                Route::get('/delete-all',  'delete_all_comments')->name('delete-all');
                Route::get('/{id}/destroy',  'destroy_trash_comments')->name('destroy');

            });

        });

    });
