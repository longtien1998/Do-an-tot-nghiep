<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\Notification\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Music\MusicController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\SingerController;
use App\Http\Controllers\Admin\Album\AlbumController;
use App\Http\Controllers\Admin\Album\S3ImgAlbumController;
use App\Http\Controllers\Admin\Copyright\CopyrightController;
use App\Http\Controllers\Admin\Publisher\PublishersController;
use App\Http\Controllers\Admin\Ads\AdvertisementsController;
use App\Http\Controllers\Admin\Ads\S3AdsController;
use App\Http\Controllers\Admin\Authorization\AuthorizationController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\Music\S3ImageController;
use App\Http\Controllers\Admin\Music\S3SongController;
use App\Http\Controllers\Admin\Music\UrlsongController;
use App\Http\Controllers\Admin\Authorization\ModuleController;
use App\Http\Controllers\Admin\Authorization\PermissionController;
use App\Http\Controllers\Admin\Authorization\RoleController;
use App\Http\Controllers\Admin\StatisticalSongController;
use App\Http\Controllers\Admin\StatisticalPayController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Auth;
use App\Exports\PaymentExport;
use App\Http\Controllers\Admin\Layout\BannerController;
use App\Http\Controllers\Admin\ContactController;
use Maatwebsite\Excel\Facades\Excel;

//test
Route::get('/test', function () {
    return view('test');
});


// lấy thông báo
Route::get('/notification-count', [NotificationController::class, 'count']);
Route::get('/banner/{id}/update/status', [BannerController::class, 'change_status']);

//authentication
route::group([
    'controller' => LoginController::class,
], function () {
    Route::get('/login',  'index')->name('login-index');
    Route::post('/login',  'authenticate')->name('login');
    Route::post('/logout',  'logout')->name('logout');
});
// check auto account anh copyright
    Route::get('/check-account', [HomeController::class, 'checkCopyrightAccount'])->name('check-copyright-account');



Route::group([
    'middleware' => ['login'],
], function () {
    // dashboard
    Route::get('/', [HomeController::class, 'home'])->name('');
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/getUser/{date}', [HomeController::class, 'getUser'])->name('getUser');
    Route::get('/getPay/{date}', [HomeController::class, 'getPay'])->name('getPay');


    //Thanh toán
    Route::group([
        'prefix' => 'payment',
        'controller' => PaymentController::class,
        'as' => 'payment.',
    ], function () {
        Route::match(['get', 'post'], '/list', 'list')->name('list');
        Route::post('/update/{id}', 'update')->name('update');
        Route::post('/search',  'search')->name('search');

    });

    // thống kê bài hát
    route::group([
        'prefix' => 'statisticalmusic',
        // 'middleware' => ['role:role_4'],
        'controller' => StatisticalSongController::class,
        'as' => 'statisticalmusic.',
    ], function () {
        Route::get('/music', 'music')->name('index');
        Route::get('/getData/{date}',  'getData')->name('getData');
        Route::post('/getSongsByDate', 'getSongsByDate')->name('getSongsByDate');

    });
    //thống kê thu nhập
    route::group([
        'prefix' => 'statisticalpay',
        // 'middleware' => ['role:role_4'],
        'controller' => StatisticalPayController::class,
        'as' => 'statisticalpay.',
    ], function () {
        Route::get('/index', 'payment')->name('index');
        Route::get('/getPay/{date}',  'getPay')->name('getPay');
        Route::post('/getPayByDate', 'getPayByDate')->name('getPayByDate');

    });

    //Export
    Route::get('/admin/statistical/payments/export', [ExportController::class, 'exportPayments'])->name('exportExcel');
    Route::get('/admin/statistical/musics/export', [ExportController::class, 'exportMusics'])->name('exportExcelMusic');


    // bài hát
    Route::group([
        'prefix' => 'songs',
        // 'middleware' => ['role:role_3'],
    ], function () {
        route::controller(MusicController::class)->group(function () {
            Route::match(['get', 'post'], '/list',  'list_music')->name('list-music')->middleware('can:songs.index');

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
            ], function () {
                Route::post('name', 'validate_name')->name('name');
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
            Route::post('/songs-destroy', [S3SongController::class, 'list_destroy_songs'])->name('s3list-destroy-songs');
        });
    });

    // quốc gia trong bài hát
    route::group([
        'prefix' => 'countries',
        // 'middleware' => ['role:role_4'],
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
        // 'middleware' => ['role:role_5'],
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
        // 'middleware' => ['role:role_7'],
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
        ], function () {
            Route::match(['get', 'post'], '/',  'trash')->name('index');
            Route::post('/search',  'search_trash_publishers')->name('search');
            Route::get('/{id}/restore', 'restore_publishers')->name('restore');
            Route::post('/restore', 'restore_list_publishers')->name('restore-list');
            Route::get('/restore-all', 'restore_all_publishers')->name('restore-all');
            Route::get('/{id}/destroy', 'destroy_publishers')->name('destroy');
            Route::post('/destroy', 'destroy_list_publishers')->name('destroy-list');
        });
        Route::get('/file-logo', 'file')->name('file');
        Route::post('/destroy-logo', 'destroy_file')->name('destroy_file');
        Route::post('/list-destroy-logo', 'list_destroy_file')->name('destroy-list-logo');
    });


    // singer

    Route::group([
        'prefix' => 'singer',
        'controller' => SingerController::class,
        'as' => 'singer.',
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
            Route::post('/search',  'search_trash_singer')->name('search');
            Route::get('/{id}/restore', 'restore_singer')->name('restore');
            Route::post('/restore', 'restore_list_singer')->name('restore-list');
            Route::get('/restore-all', 'restore_all_singer')->name('restore-all');
            Route::get('/{id}/destroy', 'destroy_singer')->name('destroy');
            Route::post('/destroy', 'destroy_list_singer')->name('destroy-list');
        });

        Route::get('/file', 'file')->name('file');
    });

    // Copyright
    Route::group([
        'prefix' => 'copyrights',
        // 'middleware' => ['role:role_6'],
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

        Route::get('/file-copyright', 'file')->name('file');
        Route::post('/destroy-file-copyright', 'destroy_file')->name('destroy_file');
        Route::post('/list-destroy-file-copyright', 'list_destroy_file')->name('destroy-list-logo');
    });


    //advertisements
    Route::group([
        'prefix' => 'advertisements',
        // 'middleware' => ['role:role_10'],
        'controller' => AdvertisementsController::class,
        'as' => 'advertisements.',
    ], function () {
        Route::match(['get', 'post'], '/list',  'list_advertisements')->name('list');
        Route::get('/create',  'add_advertisements')->name('create');
        Route::post('/store',  'storeAdvertisements')->name('store');
        Route::get('/{id}/edit',  'edit_advertisements')->name('edit');
        Route::put('/{id}/update',  'update_advertisements')->name('update');
        Route::post('/search',  'searchAds')->name('search');
        Route::delete('/{id}/delete',  'delete')->name('delete');
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
        // 'middleware' => ['role:role_11'],
        'controller' => UsersController::class,
        'as' => 'users.',
    ], function () {
        Route::match(['get', 'post'], '/list',  'list_users')->name('list');
        Route::get('/create',  'add_users')->name('create');
        Route::post('/store',  'storeAddUser')->name('store');
        Route::put('/update-pass/{id}',  'updatePass')->name('updatePass');
        Route::get('/{id}/edit',  'edit_users')->name('edit');
        Route::put('/{id}/update',  'update_users')->name('update');
        Route::post('/search',  'searchUser')->name('search');
        Route::delete('/{id}/delete',  'delete_users')->name('delete');
        Route::post('/delete-list',  'delete_list_users')->name('delete-list');
        Route::get('/{id}/show',  'show_user')->name('show');

        //trash
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
        // 'middleware' => ['role:role_12'],
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

    //Modules
    Route::group([
        'prefix' => 'modules',
        // 'middleware' => ['role:role_13'],
        'controller' => ModuleController::class,
        'as' => 'modules.',
    ], function () {
        Route::match(['get', 'post'], '/',  'index')->name('index');
        Route::get('/create',  'create')->name('create');
        Route::post('/store',  'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::put('/{id}/update',  'update')->name('update');
        Route::post('/search',  'search')->name('search');
        Route::delete('/{id}/delete',  'destroy')->name('delete');
        Route::post('/delete-list',  'delete_list')->name('delete-list');
    });

    //Permissions
    Route::group([
        'prefix' => 'permissions',
        // 'middleware' => ['role:role_13'],
        'controller' => PermissionController::class,
        'as' => 'permissions.',
    ], function () {
        Route::match(['get', 'post'], '/',  'index')->name('index');
        Route::get('/create',  'create')->name('create');
        Route::post('/store',  'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::patch('/{id}/update',  'update')->name('update');
        Route::post('/search',  'search')->name('search');
        Route::delete('/{id}/delete',  'destroy')->name('delete');
        Route::post('/delete-list',  'delete_list')->name('delete-list');
    });

    //roles
    Route::group([
        'prefix' => 'roles',
        // 'middleware' => ['role:role_13'],
        'controller' => RoleController::class,
        'as' => 'roles.',
    ], function () {
        Route::match(['get', 'post'], '/',  'index')->name('index');
        Route::get('/create',  'create')->name('create');
        Route::post('/store',  'store')->name('store');
        Route::get('/{role}/edit',  'edit')->name('edit');
        Route::put('/{role}/update',  'update')->name('update');
        Route::post('/search',  'search')->name('search');
        Route::delete('/{role}/delete',  'destroy')->name('delete');
        Route::post('/delete-list',  'delete_list')->name('delete-list');
    });
    // Route::resource('roles',RoleController::class);


    //authorization
    Route::group([
        'prefix' => 'authorization',
        // 'middleware' => ['role:role_13'],
        'controller' => AuthorizationController::class,
        'as' => 'authorization.',
    ], function () {
        Route::match(['get', 'post'], '/',  'index')->name('index');
        Route::put('/{user}/update',  'update')->name('update');
        Route::post('/search',  'search')->name('search');
    });


    //album

    Route::group([
        'prefix' => 'albums',
        'controller' => AlbumController::class,
        'as' => 'albums.',
    ], function () {


        Route::match(['get', 'post'],'/', 'index')->name('list'); // Trang danh sách album
        Route::get('/create', 'add_album')->name('add'); // Trang thêm mới album
        Route::post('/search',  'search_album')->name('search');
        Route::post('/', 'store_album')->name('store'); // Xử lý lưu album
        Route::get('/{id}/edit', 'edit_album')->name('edit'); // Trang chỉnh sửa album
        Route::put('/{id}', 'update_album')->name('update'); // Xử lý cập nhật album
        Route::delete('/{id}/delete', 'delete_album')->name('delete'); // Xử lý lưu album
        Route::post('/list/delete', 'delete_list')->name('delete-list'); // Xóa danh sách album
        // Route::get('/singer/{id}/albums','showAlbumsWithAllSongs')->name('singer.albums');
        route::prefix('s3')->group(function () {
            // hình ảnh trên AWS S3
            Route::get('/images', [S3ImgAlbumController::class, 'image_albums'])->name('s3images.index');
            Route::post('/images', [S3ImgAlbumController::class, 'destroy_image_albums'])->name('s3images.destroy');
            Route::post('/images-destroy', [S3ImgAlbumController::class, 'list_destroy_image_albums'])->name('s3list-destroy-image-albums');
        });
        Route::group([
            'prefix' => 'trash',
            'as' => 'trash.',
        ], function () {
            Route::match(['get', 'post'],'/list',  'list_trash_album')->name('list');
            Route::post('/search',  'search_album_trash')->name('search');
            Route::post('/restore',  'restore_trash_album')->name('restore');
            Route::get('/restore-all',  'restore_all_album')->name('restore-all');
            Route::post('/delete',  'delete_trash_album')->name('delete');
            Route::get('/delete-all',  'delete_all_album')->name('delete-all');
            Route::get('/{id}/destroy',  'destroy_trash_album')->name('destroy');
        });
        // ALbum_song route
        Route::group([
            'prefix' => 'albumsongs',
            'as' => 'albumsongs.',
        ], function () {
            Route::match(['get', 'post'],'/list',  'list_album_song')->name('list');
            Route::post('/add', 'add_album_song')->name('add');
            Route::put('/{id}/update',  'update_album_song')->name('update');
            Route::delete('/{id}/delete',  'delete_album_song')->name('delete');
            Route::post('/list/delete', 'delete_list_album_song')->name('delete-list');

        });
    });


    // banner
    Route::group([
        'prefix' => 'banner',
        // 'middleware' => ['role:role_7'],
        'controller' => BannerController::class,
        'as' => 'banner.',
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
            Route::post('/search',  'search_trash_banner')->name('search');
            Route::get('/{id}/restore', 'restore_banner')->name('restore');
            Route::post('/restore', 'restore_list_banner')->name('restore-list');
            Route::get('/restore-all', 'restore_all_banner')->name('restore-all');
            Route::get('/{id}/destroy', 'destroy_banner')->name('destroy');
            Route::post('/destroy', 'destroy_list_banner')->name('destroy-list');
        });
        Route::get('/file-banner', 'file')->name('file');
        Route::post('/destroy-banner', 'destroy_file')->name('destroy_file');
        Route::post('/list-destroy-banner', 'list_destroy_file')->name('destroy-list-banner');
    });

    Route::group([
        'prefix' => 'contact',
        // 'middleware' => ['role:role_7'],
        'controller' => ContactController::class,
        'as' => 'contact.',
    ], function () {
        Route::match(['get', 'post'], '/',  'index')->name('index');
        Route::post('/search',  'search')->name('search');
        Route::get('/create',  'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::put('/{id}/update',  'update')->name('update');
        Route::delete('/{id}/delete',  'delete')->name('delete');
        Route::post('/delete-list',  'delete_list')->name('delete-list');
    });

});
// đóng group midle login
