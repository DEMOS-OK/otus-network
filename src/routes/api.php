<?php

use App\SocialNetwork\UI\Http\Controllers\API\AuthController;
use App\SocialNetwork\UI\Http\Controllers\API\FriendController;
use App\SocialNetwork\UI\Http\Controllers\API\UserController;
use App\SocialNetwork\UI\Http\Middleware\JWTAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function () {
    Route::middleware(JWTAuth::class)->group(static function () {
        Route::get('/user/friend/', [FriendController::class, 'getFriends']);
        Route::post('/user/friend/{friendId}', [FriendController::class, 'addFriend']);
        Route::delete('/user/friend/{friendId}', [FriendController::class, 'deleteFriend']);
    });

    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::get('/user/search/', [UserController::class, 'search']);
    Route::get('/user/{id}', [UserController::class, 'find']);
});
