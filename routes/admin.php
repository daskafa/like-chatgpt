<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('login', [AdminController::class, 'login']);
Route::post('authenticate', [AdminController::class, 'authenticate']);

Route::get('dashboard', [AdminController::class, 'dashboard'])->middleware(IsAdminMiddleware::class);
Route::get('logout', [AdminController::class, 'logout']);
