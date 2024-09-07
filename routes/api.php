<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::apiResource('/images', ImageController::class   );
Route::apiResource('/categories', \App\Http\Controllers\Api\V1\CategoryController::class);
Route::apiResource('/tags', \App\Http\Controllers\Api\V1\TagController::class);

require __DIR__.'/auth.php';
