<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentVnpController;
use App\Http\Controllers\Api\PaymentMomoController;

Route::get('/test', [App\Http\Controllers\Api\TestController::class, 'test']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'controller' => App\Http\Controllers\Api\AuthController::class,
], function () {
    Route::post('users/login', 'login');
    // đăng ký member
    Route::post('users/register', 'register');
    // refresh token
    Route::get('token/refresh', 'refresh');

    // reset password
    Route::post('/resetpassword', 'resetPassword');
    //check otp
    Route::post('/check-otp', 'checkOtp');
    // new password
    Route::post('/newpassword', 'newPassword');
});

// đăng nhập member
Route::group([
    'middleware' => ['auth:api'],
], function () {
    // đăng xuất
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/member', [App\Http\Controllers\Api\MemberController::class, 'index']);
    // New Pass member
    Route::put('/{id}/newpass-member', [App\Http\Controllers\Api\MemberController::class, 'newpass']);
    Route::put('/{id}/update-member', [App\Http\Controllers\Api\MemberController::class, 'update']);



    //Bài hát yêu thích
    Route::get('/{id}/bai-hat-yeu-thich', [App\Http\Controllers\Api\FavouriteSongController::class, 'list_song_favourite']);
    //Add Bài hát yêu thích
    Route::post('/bai-hat-yeu-thich', [App\Http\Controllers\Api\FavouriteSongController::class, 'add_song_favourite']);
    //check Bài hát yêu thích
    Route::post('/check-bai-hat-yeu-thich', [App\Http\Controllers\Api\FavouriteSongController::class, 'check_song_favourite']);
    //Add binh luận
    Route::post('/binh-luan', [App\Http\Controllers\Api\CommentController::class, 'add_comment']);


    // api thanh toán vnpay
    Route::post('/create-vnpay-url', [PaymentVnpController::class, 'createVnpayUrl']);
    Route::get('/vnpay-return', [PaymentVnpController::class, 'vnpayReturn']);
    // api thanh toán momo
    Route::post('/create-momo-url', [PaymentMomoController::class, 'createMomoUrl']);
    Route::get('/momo-return', [PaymentMomoController::class, 'momoReturn']);

    //lịch sử thanh toán
    Route::get('/{user_id}/history', [App\Http\Controllers\Api\PaymentController::class, 'index']);

    // thêm ca sĩ vào yêu thích
    Route::post('/ca-si/add-to-favourite', [App\Http\Controllers\Api\SingerController::class, 'addFavourite']);
    // xóa ca si khỏi yêu thích
    Route::post('/ca-si/remove-from-favourite', [App\Http\Controllers\Api\SingerController::class, 'removeFavourite']);
    //danh sách ca sĩ yêu thích theo user
    Route::get('/{user_id}/ca-si-yeu-thich', [App\Http\Controllers\Api\FavouriteSingerController::class, 'getAll']);
    // check ca sĩ yêu thích
    Route::get('/check-ca-si-yeu-thich/{user_id}/{singer_id}', [App\Http\Controllers\Api\FavouriteSingerController::class, 'checkFavourite']);

    //Liên hệ
    Route::post('/lien-he', [App\Http\Controllers\Api\ContactController::class,'store']);



    // danh sách playlist với suser_id
    Route::get('/playlist-user/{user_id}', [App\Http\Controllers\Api\PlaylistController::class, 'index']);
    // thêm playlist với user_id
    Route::post('/playlist-user', [App\Http\Controllers\Api\PlaylistController::class, 'store']);
    // xóa playlist với user_id
    Route::get('/playlist-user/{playlist_id}', [App\Http\Controllers\Api\PlaylistController::class, 'destroy']);
    // thêm bài hát vào playlist
    Route::post('/playlist-user/{playlist_id}/add-song', [App\Http\Controllers\Api\PlaylistController::class, 'addSong']);
    // xóa bài hát khỏi playlist
    Route::get('/playlist-user/{playlist_id}/remove-song/{song_id}', [App\Http\Controllers\Api\PlaylistController::class, 'removeSong']);
    // danh sách bài hát với playlist
    Route::get('/playlist-song/{playlist_id}', [App\Http\Controllers\Api\PlaylistController::class, 'list_song']);
    //chi tiết playlist private
    Route::get('/playlist-private/{playlist_id}', [App\Http\Controllers\Api\PlaylistController::class, 'public_playlist_detail']);


    // ablbum yêu thích với user
    Route::get('/{user_id}/album-yeu-thich', [App\Http\Controllers\Api\FavouriteAlbumController::class, 'getAll']);
    // thêm album vào yêu thích
    Route::post('/album-yeu-thich', [App\Http\Controllers\Api\FavouriteAlbumController::class, 'addFavourite']);

});

// lấy banner
Route::get('/banner', [App\Http\Controllers\Api\BannerController::class, 'index']);

//Show bình luận theo id bài hát
Route::get('/binh-luan/{id}', [App\Http\Controllers\Api\CommentController::class, 'show_comment']);

// tìm kiếm
Route::post('/tim-kiem', [App\Http\Controllers\Api\SearchController::class, 'search']);
// Random quảng cảo
Route::get('/quang-cao', [App\Http\Controllers\Api\AdvertisementsController::class, 'randomAds']);
// chi tiết nhà xuất bản
Route::get('/nha-xuat-ban/{id}', [App\Http\Controllers\Api\PublisherController::class, 'show']);
// lượt nghe
Route::get('/luot-nghe/{id}', [App\Http\Controllers\Api\SongsController::class, 'luot_nghe']);
// lượt tải
Route::get('/luot-tai/{id}', [App\Http\Controllers\Api\SongsController::class, 'luot_tai']);


// chọn bài nghe
Route::get('/{id}/play', [App\Http\Controllers\Api\SongsController::class, 'play']);
// chi tiết bài hát
Route::get('/bai-hat/{id}', [App\Http\Controllers\Api\SongsController::class, 'show']);
// Bxh 100 bài hát hàng tuần
Route::get('/bxh-100', [App\Http\Controllers\Api\SongsController::class, 'bxh_100']);
// 10 bài hát mới nhất
Route::get('/new-song', [App\Http\Controllers\Api\SongsController::class, 'new_song']);
// top trending / thịnh hành
Route::get('/trending', [App\Http\Controllers\Api\SongsController::class, 'list_song_trending']);
// top 100 lượt nghe
Route::get('/top-listen', [App\Http\Controllers\Api\SongsController::class, 'top_listen']);
// top 100 lượt yêu thích
Route::get('/top-like', [App\Http\Controllers\Api\SongsController::class, 'top_like']);
// top 100 lượt tải
Route::get('/top-download', [App\Http\Controllers\Api\SongsController::class, 'top_download']);

// top 1 trending / thịnh hành
Route::get('/top-1-trending', [App\Http\Controllers\Api\SongsController::class, 'top1_trending']);
// top 1 lượt nghe
Route::get('/top-1-listen', [App\Http\Controllers\Api\SongsController::class, 'top1_listen']);
// top 1 lượt yêu thích
Route::get('/top-1-like', [App\Http\Controllers\Api\SongsController::class, 'top1_like']);


// 10 bài hát ngẫu nhiên
Route::get('/rand-10', [App\Http\Controllers\Api\SongsController::class, 'songs_rand_10']);


// thể loại quốc gia
Route::get('/quoc-gia', [App\Http\Controllers\Api\CountryController::class, 'index']);
// Bài hát theo quốc gia
Route::get('/quoc-gia/{id}/bai-hat', [App\Http\Controllers\Api\SongsController::class, 'list_song_Country']);
// Thể loại Bài hát
Route::get('/the-loai', [App\Http\Controllers\Api\CategoryController::class, 'index']);
// Bài hát theo thể loại
Route::get('/the-loai/{id}/bai-hat', [App\Http\Controllers\Api\SongsController::class, 'list_song_category']);



// Ca sĩ
Route::get('/ca-si', [App\Http\Controllers\Api\SingerController::class, 'index']);
// Thông tin ca sĩ
Route::get('/ca-si/{singer_id}', [App\Http\Controllers\Api\SingerController::class, 'show']);
// Bài hát theo Ca sĩ
Route::get('/ca-si/{singer_id}/bai-hat', [App\Http\Controllers\Api\SongsController::class, 'list_song_singer']);
// Album theo ca sĩ
Route::get('/ca-si/{singer_id}/album', [App\Http\Controllers\Api\AlbumController::class, 'album_singer']);

// playlist công khai
Route::get('/playlist-public', [App\Http\Controllers\Api\PlaylistController::class, 'public_playlist']);
// playlist detail công khai
Route::get('/playlist-public/{playlist_id}', [App\Http\Controllers\Api\PlaylistController::class, 'public_playlist_detail']);
// playlist song công khai
Route::get('/playlist-public/{playlist_id}/song', [App\Http\Controllers\Api\PlaylistController::class, 'public_playlist_song']);

// Album
Route::get('/album', [App\Http\Controllers\Api\AlbumController::class, 'index']);
// Thông tin album
Route::get('/album/{album_id}', [App\Http\Controllers\Api\AlbumController::class, 'show']);
// Bài hát trong album
Route::get('/album/{album_id}/bai-hat', [App\Http\Controllers\Api\AlbumController::class, 'list_song_album']);
// Album theo ca sĩ
Route::get('/album/{singer_id}/ca-si', [App\Http\Controllers\Api\AlbumController::class, 'album_singer']);

