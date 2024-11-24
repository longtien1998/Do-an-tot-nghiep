<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test',[App\Http\Controllers\Api\TestController::class,'test']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'controller' => App\Http\Controllers\Api\AuthController::class,
], function () {
    Route::post('users/login', 'login');
    // đăng ký member
    Route::post('users/register', 'register');

    // reset password
    Route::post('/resetpassword', 'resetPassword');
    //check otp
    Route::post('/check-otp', 'checkOtp');
    // new password
    Route::post('/newpassword', 'newPassword');
});
// đăng nhập member

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    // đăng xuất
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/member', [App\Http\Controllers\Api\MemberController::class, 'index']);
    // New Pass member
    Route::put('/{id}/newpass-member',[App\Http\Controllers\Api\MemberController::class,'newpass']);
    Route::put('/{id}/update-member',[App\Http\Controllers\Api\MemberController::class,'update']);
});
// show member

// chi tiết bài hát
Route::get('/bai-hat/{id}', [App\Http\Controllers\Api\SongsController::class,'show']);
// chi tiết nhà xuất bản
Route::get('/nha-xuat-ban/{id}', [App\Http\Controllers\Api\PublisherController::class, 'show']);
// lượt nghe
Route::get('/luot-nghe/{id}', [App\Http\Controllers\Api\SongsController::class, 'luot_nghe']);
// lượt tải
Route::get('/luot-tai/{id}', [App\Http\Controllers\Api\SongsController::class, 'luot_tai']);
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
// 10 bài hát ngẫu nhiên
Route::get('/rand-10', [App\Http\Controllers\Api\SongsController::class, 'songs_rand_10']);
// thể loại quốc gia
Route::get('/quoc-gia',[App\Http\Controllers\Api\CountryController::class, 'index']);
// Bài hát theo quốc gia
Route::get('/quoc-gia/{id}/bai-hat',[App\Http\Controllers\Api\SongsController::class, 'list_song_Country']);
// Thể loại Bài hát
Route::get('/the-loai',[App\Http\Controllers\Api\CategoryController::class, 'index']);
// Bài hát theo thể loại
Route::get('/the-loai/{id}/bai-hat',[App\Http\Controllers\Api\SongsController::class, 'list_song_category']);
// Ca sĩ
Route::get('/ca-si',[App\Http\Controllers\Api\SingerController::class, 'index']);
// Bài hát theo Ca sĩ
Route::get('/ca-si/{id}/bai-hat',[App\Http\Controllers\Api\SongsController::class, 'list_song_singer']);
//Bài hát yêu thích
Route::get('/{id}/bai-hat-yeu-thich',[App\Http\Controllers\Api\FavouriteSongController::class, 'list_song_favourite']);
//Add Bài hát yêu thích
Route::post('/bai-hat-yeu-thich',[App\Http\Controllers\Api\FavouriteSongController::class, 'add_song_favourite']);
//Xóa Bài hát yêu thích
Route::post('/xoa-bai-hat-yeu-thich',[App\Http\Controllers\Api\FavouriteSongController::class, 'delete_song_favourite']);
//Add binh luận
Route::post('/binh-luan',[App\Http\Controllers\Api\CommentController::class,'add_comment']);
//Show bình luận theo id bài hát
Route::get('/binh-luan/{id}',[App\Http\Controllers\Api\CommentController::class,'show_comment']);
// Random quảng cảo
Route::get('/quang-cao', [App\Http\Controllers\Api\AdvertisementsController::class,'randomAds']);
// tìm kiếm
Route::post('/tim-kiem', [App\Http\Controllers\Api\SearchController::class,'search']);
