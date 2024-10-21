<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['namespace' => 'Api'], function(){
    // member
    // đăng nhập member
    Route::post('users/login',[App\Http\Controllers\Api\AuthController::class, 'login']);
    // đăng ký member
    Route::post('users/register',[App\Http\Controllers\Api\AuthController::class, 'register']);
    // đăng xuất
    Route::get('users/logout',[App\Http\Controllers\Api\AuthController::class, 'logout']);
    // reset password
    Route::post('/resetpassword',[App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
    //check otp
    Route::post('/check-otp',[App\Http\Controllers\Api\AuthController::class, 'checkOtp']);
    // new password
    Route::post('/newpassword',[App\Http\Controllers\Api\AuthController::class, 'newPassword']);

    // show member
    Route::get('/member',[App\Http\Controllers\Api\MemberController::class, 'index']);

    // lượt nghe
    Route::get('/luot-nghe/{id}',[App\Http\Controllers\Api\SongsController::class, 'luot_nghe']);
    // lượt tải
    Route::get('/luot-tai/{id}',[App\Http\Controllers\Api\SongsController::class, 'luot_tai']);
    // Bxh 100
    Route::get('/bxh-100',[App\Http\Controllers\Api\SongsController::class, 'bxh_100']);
    // 10 bài hát ngẫu nhiên
    Route::get('/rand-10',[App\Http\Controllers\Api\SongsController::class, 'songs_rand_10']);
});
