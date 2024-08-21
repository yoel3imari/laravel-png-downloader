<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\TagController;
use Illuminate\Support\Facades\Route;

// auth

// main
Route::resource('/images', ImageController::class);
Route::resource('/categories', CategoryController::class);
Route::resource('/tags', TagController::class);
