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
    // show member
    Route::get('/member',[App\Http\Controllers\Api\MemberController::class, 'index']);
    // reset password
    Route::post('/resetpassword',[App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
    // new password
    Route::post('/newpassword',[App\Http\Controllers\Api\AuthController::class, 'newPassword']);

});
