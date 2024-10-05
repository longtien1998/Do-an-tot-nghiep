<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
'namespace' => 'Api'
], function(){
    // member
    Route::post('/login',[App\Http\Controllers\Api\MemberController::class, 'login']);
    Route::post('/register',[App\Http\Controllers\Api\MemberController::class, 'register']);

});
