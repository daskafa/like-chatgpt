<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::post('auth', [AuthController::class, 'auth']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('subscription', [SubscriptionController::class, 'subscription']);
    Route::post('chat', [ChatController::class, 'chat']);
});
