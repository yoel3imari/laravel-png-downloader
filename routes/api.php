<?php

use App\Http\Controllers\Api\V1\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// auth

// main
Route::resource('/images', ImageController::class);
