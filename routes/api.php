<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostActivityController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryController::class);
Route::get('posts/{post}/activity', [PostActivityController::class, 'show']);