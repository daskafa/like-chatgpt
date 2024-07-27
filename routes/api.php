<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::post('auth', [AuthController::class, 'auth']);
Route::post('subsciption', [SubscriptionController::class, 'subscription']);
