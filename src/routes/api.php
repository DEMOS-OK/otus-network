<?php

use App\SocialNetwork\UI\Http\Controllers\API\AuthController;
use App\SocialNetwork\UI\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function () {
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::get('/user/search/', [UserController::class, 'search']);
    Route::get('/user/{id}', [UserController::class, 'find']);
});
