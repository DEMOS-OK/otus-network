<?php

use App\SocialNetwork\UI\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function () {
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::get('/user/{id}', [AuthController::class, 'login']);
});
